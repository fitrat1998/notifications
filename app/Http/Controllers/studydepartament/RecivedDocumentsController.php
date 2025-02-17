<?php

namespace App\Http\Controllers\studydepartament;

use App\Http\Controllers\Controller;
use App\Http\Requests\studydepartament\StoreRecivedDocumentsRequest;
use App\Http\Requests\studydepartament\UpdateRecivedDocumentsRequest;
use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\RecivedDocuments;
use App\Models\studydepartament\UserDocuments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class RecivedDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $ids = DB::table('tasks_has_departments')->where('department_id', $user->department_id)->pluck('task_id');

        $sends = SendTask::whereIn('id', $ids)->get();

        $sends_id = $sends->pluck('id')->toArray();

        $done = Donetask::whereIn('task_id', $sends_id)->pluck('task_id')->toArray();

        $count = SendTask::whereNotIn('id', $done)->count();


        $id_docs = DB::table('userdocs_has_departments')->where('department_id', $user->department_id)->pluck('userdocs_id');

        $docs = UserDocuments::whereIn('id', $id_docs)->get();

        $docs_id = $docs->pluck('id')->toArray();

        $done_docs = DoneUserDocs::whereIn('userdocs_id', $docs_id)->pluck('userdocs_id')->toArray();

        $count_docs = UserDocuments::whereNotIn('id', $done_docs)
            ->where('status', '!=', 'cancelled')
            ->count();

        $users = User::where('department_id', '!=', '')
//            ->where('department_id', '!=', $user->department_id)
            ->pluck('id');


        $department_id = auth()->user()->department_id;

        $documenttype_id = DB::table('confirm_departments_map')
            ->where('department_id', $user->department_id)
            ->pluck('documenttype_id');


        $user_documents_id = DB::table('userdocs_has_departments')
            ->where('department_id', $department_id)
            ->distinct('id')
            ->pluck('userdocs_id');

        $user_documents = UserDocuments::whereIn('id', $user_documents_id)
            ->orderBy('id', 'desc')
            ->get();



        return view('studydepartments.reciveddocuments.index', compact('count', 'count_docs', 'user_documents'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $send = Donetask::where('status', 'waiting')->get();

        $accepted = Donetask::where('status', 'accepted')->get();

        $cancelled = Donetask::where('status', 'cancelled')->get();

        return view('admin.notifications.index', compact('send', 'cancelled', 'accepted'));
    }

    public function accepted_done()
    {
        $send = Donetask::where('status', 'waiting')->get();

        $accepted = Donetask::where('status', 'accepted')->get();

        $cancelled = Donetask::where('status', 'cancelled')->get();

        return view('admin.notifications.accepted', compact('send', 'cancelled', 'accepted'));
    }

    public function cancelled_done()
    {
        $send = Donetask::where('status', 'waiting')->get();

        $accepted = Donetask::where('status', 'accepted')->get();

        $cancelled = Donetask::where('status', 'cancelled')->get();

        return view('admin.notifications.cancelled', compact('send', 'cancelled', 'accepted'));
    }

    public function accept(Request $request)
    {
        $user = auth()->user();
        $done = Donetask::find($request->accept);

        $done->update([
            'status' => 'accepted',
            'cancelled_user' => $user->id,
            'updated_at' => NOW(),
        ]);

        return redirect()->back()->with('success', 'Topshiriq muvaffaqiyatli qabul qilindi');
    }

    public function cancel(Request $request)
    {
        $user = auth()->user();

        $done = Donetask::find($request->cancel);


        $done->update([
            'status' => 'cancelled',
            'report' => $request->report,
            'cancelled_user' => $user->id,
            'updated_at' => NOW(),
        ]);

        return redirect()->back()->with('danger', 'Topshiriq rad etildi');

    }


    public function detail($id)
    {

        $userdoc = UserDocuments::find($id);

        return view('studydepartments.reciveddocuments.detail', compact('userdoc'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecivedDocumentsRequest $request)
    {

        $user = auth()->user();

//        dd($request);

        $userdocs = UserDocuments::find($request->reject_id);

        $departments = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdocs->id)
            ->where('department_id', $request->department_id)
            ->update([
                'status' => 'cancelled',
                'updated_at' => NOW(),
            ]);

        $userdocs->update([
            'status' => 'cancelled',
            'report' => $request->comment,
            'cancelled_user' => $user->id,
            'updated_at' => NOW(),
        ]);

//        $departments->delete();

        return redirect()->route('reciveddocuments.index')->with('danger', 'Hujjat qabul qilindi');


    }

    /*** Display the specified resource. */
    public function show($id)
    {

        $id = intval($id);

        $user = auth()->user();

        $users = User::where('department_id', '!=', '')
            ->where('department_id', '!=', $user->department_id)
            ->pluck('id');

        $documenttype_id = DB::table('documenttypes_has_deparments')
            ->where('department_id', $user->department_id)
            ->pluck('documenttype_id');

        $userdocs = UserDocuments::whereIn('user_id', $users)
            ->whereIn('documenttype_id', $documenttype_id)
            ->get();

        $userdoc = UserDocuments::find($id);

        return view('studydepartments.reciveddocuments.done', compact('userdocs', 'id', 'userdoc'));

    }

    public function reject($id)
    {
//        return $id;
        $user = auth()->user();

        $users = User::where('department_id', '!=', '')
            ->where('department_id', '!=', $user->department_id)
            ->pluck('id');

        $documenttype_id = DB::table('documenttypes_has_deparments')
            ->where('department_id', $user->department_id)
            ->pluck('documenttype_id');

        $userdocs = UserDocuments::find($id);

        return view('studydepartments.reciveddocuments.reject', compact('userdocs', 'id'));

    }

    public function final_step(Request $request, $id)
    {
//        dd($request);
        $user = auth()->user()->id;

        $request->validate([
            'comment' => 'required|string|max:255',
            'department_id' => '',
            'files.*' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        $userdocs = UserDocuments::findOrFail($id);

        $doctype_id = $request->input('doctype_id');


        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $hashedName = $file->hashName();
                $filePath = $file->storeAs('final_steps', $hashedName);

                $existingFile = DB::table('final_step_files')
                    ->where('user_id', auth()->user()->id)
                    ->where('department_id', $request->department_id)
                    ->where('userdocs_id', $userdocs->id)
                    ->where('doctype_id', $doctype_id)
                    ->where('name', $file->getClientOriginalName())
                    ->first();

                if (!$existingFile) {
                    DB::table('final_step_files')->insert([
                        'user_id' => auth()->user()->id,
                        'department_id' => $request->department_id,
                        'name' => $file->getClientOriginalName(),
                        'file' => $hashedName,
                        'userdocs_id' => $userdocs->id,
                        'doctype_id' => $doctype_id,
                        'comment' => $request->comment,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    return redirect()->route('reciveddocuments.index')->with('success', 'Ilova muvaffaqiyatli yuklandi!');

                } else {
                    // Optionally, delete the stored file if it already exists in the database
                    Storage::delete($filePath);
                }
            }
        } else {
            $exists = DB::table('final_step_files')
                ->where('user_id', auth()->user()->id)
                ->where('department_id', $request->department_id)
                ->where('userdocs_id', $userdocs->id)
                ->where('doctype_id', $doctype_id)
                ->exists();

            if (!$exists) {
                DB::table('final_step_files')->insert([
                    'user_id' => auth()->user()->id,
                    'department_id' => $request->department_id,
                    'name' => 'empty',
                    'file' => 'empty',
                    'userdocs_id' => $userdocs->id,
                    'doctype_id' => $doctype_id,
                    'comment' => $request->comment,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return redirect()->route('reciveddocuments.index')->with('success', 'Ilova muvaffaqiyatli yuklandi!');

            }
        }

        return redirect()->route('reciveddocuments.index')->with('danger', 'Bu malumotlar avval kiritilgan!');

    }

    public function final_step_view($id)
    {
        $user = auth()->user();

        $final = DB::table('final_step_files')->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        $userdocs = UserDocuments::find($final->userdocs_id);

        return view('studydepartments.reciveddocuments.list_final_step', compact('userdocs'));
    }

    public function download($filename)
    {
        $filePath = public_path('storage/final_steps/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return abort(404, 'File not found.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(RecivedDocuments $recivedDocuments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(UpdateRecivedDocumentsRequest $request, RecivedDocuments $recivedDocuments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(RecivedDocuments $recivedDocuments)
    {
        //
    }
}
