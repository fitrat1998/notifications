<?php

namespace App\Http\Controllers\studydepartament;

use App\Http\Controllers\Controller;
use App\Http\Requests\studydepartament\StoreDoneUserDocsRequest;
use App\Http\Requests\studydepartament\UpdateDoneUserDocsRequest;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\UserDocuments;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoneUserDocsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function view($id)
    {
        $user = auth()->user();
        $done = DoneUserDocs::where('userdocs_id', $id)
            ->where('user_id', $user->id)
            ->first();

        return view('studydepartments.reciveddocuments.list', compact('done'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoneUserDocsRequest $request)
    {

        $request->validated();


        $userdocs = UserDocuments::find($request->userdocs_id);

        $user = auth()->user();

        $exists = DoneUserDocs::where('userdocs_id', intval($request->userdocs_id))
            ->where('user_id', $user->id)
            ->first();

        if ($exists) {
            return redirect()->back()->with('danger', 'Bu malumotlar allaqachon mavjud');

        } else {


            if ($request->file('files')) {
                $create = DoneUserDocs::create([
                    'user_id' => $user->id,
                    'userdocs_id' => intval($request->userdocs_id),
                    'comment' => $request->comment,
                    'deadline' => NOW(),
                    'status' => "waiting",
                    'step' => 0,
                    'report' => 'empty',
                ]);

                $department = DB::table('userdocs_has_departments')
                    ->where('userdocs_id', $request->userdocs_id)
                    ->where('department_id', $user->department_id)
                    ->update([
                        'status' => 'accepted',
                        'updated_at' => NOW()
                    ]);

                $done = $create->id;

                foreach ($request->file('files') as $file) {

                    $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                    $filePath = public_path('storage/doneuserdocs/' . $name);
                    $file->move(public_path('storage/doneuserdocs'), $name);

                    DB::table('done_user_docs_files')->insert([
                        'userdocs_id' => intval($request->userdocs_id),
                        'done_user_docs_id' => $done,
                        'name' => $name,
                        'title' => $file->getClientOriginalName(),
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]);
                }

                $userdocs->update([
                    'status' => 'accepted',
                ]);

            } else {
                $create = DoneUserDocs::create([
                    'user_id' => $user->id,
                    'userdocs_id' => intval($request->userdocs_id),
                    'comment' => $request->comment,
                    'deadline' => NOW(),
                    'status' => "waiting",
                    'step' => 0,
                    'report' => 'empty',
                ]);

                $department = DB::table('userdocs_has_departments')
                    ->where('userdocs_id', $request->userdocs_id)
                    ->where('department_id', $user->department_id)
                    ->update([
                        'status' => 'accepted',
                        'created_at' => NOW(),
                        'updated_at' => NOW()
                    ]);

                $userdocs->update([
                    'status' => 'accepted',
                ]);
            }

        }

        return redirect()->route('reciveddocuments.index')->with('success', 'Topshiriq muvaffaqiyatli bajarildi');
    }

    /**
     * Display the specified resource.
     */
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

        return view('studydepartments.reciveddocuments.done', compact('userdocs', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $user_id = auth()->user();

        $tasks = DoneUserDocs::all();

        $done = DoneUserDocs::find($id);

        return view('studydepartments.reciveddocuments.edit', compact('done', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoneUserDocsRequest $request, $id)
    {


        $user = auth()->user();

        $update = DoneUserDocs::find($id);

        $up = $update->update([
            'user_id' => $user->id,
            'userdocs_id' => $request->userdocs_id,
            'comment' => $request->comment,
            'deadline' => NOW(),
        ]);

        if ($request->file('files')) {
            $existingFiles = DB::table('done_user_docs_files')
                ->where('done_user_docs_id', intval($update->id))
                ->where('userdocs_id', intval($request->userdocs_id))
                ->get();

            foreach ($existingFiles as $existingFile) {
                Storage::delete('storage/doneuserdocs/' . $existingFile->name);
                $d = DB::table('done_user_docs_files')
                    ->where('userdocs_id', intval($update->userdocs_id))
                    ->where('done_user_docs_id', $update->id)
                    ->where('name', $existingFile->name)
                    ->where('created_at', $existingFile->created_at)
                    ->delete();
            }

            $files = $request->file('files.*');

            foreach ($files as $file) {

                $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $filePath = public_path('storage/doneuserdocs/' . $name);
                $file->move(public_path('storage/doneuserdocs/'), $name);

                DB::table('done_user_docs_files')->insert([
                    'userdocs_id' => intval($request->userdocs_id),
                    'done_user_docs_id' => $update->id,
                    'name' => $name,
                    'title' => $file->getClientOriginalName(),
                    'created_at' => NOW(),
                ]);
            }
        }

        return redirect()->route('reciveddocuments.index')->with('success', 'Topshiriq muvaffaqiyatli tahrirlandi');

    }

    public function download($filename)
    {
        $filePath = public_path('storage/doneuserdocs/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return abort(404, 'File not found.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $done = DoneUserDocs::find($id);


        $deletes = DB::table('done_user_docs_files')->where('done_user_docs_id', $id)->get();


        foreach ($deletes as $d) {
            $f = Storage::delete('storage/doneuserdocs/' . $d->name);
            if ($f) {
                echo "Fayl muvaffaqiyatli o'chirildi: " . $d->name;
            } else {
                echo "Fayl o'chirishda xatolik yuz berdi: " . $d->name;
            }
        }

        $deleteT = DB::table('done_tasks_has_files')->where('done_id', $id)->delete();

        DB::table('userdocs_has_departments')
            ->where('userdocs_id', $done->userdocs_id)
            ->where('updated_at', $done->updated_at)
            ->update([
                'status' => 'waiting'
            ]);

        $done->delete();

        return redirect()->route('reciveddocuments.index')->with('success', 'Topshiriq muvaffaqiyatli o`chirildi');
    }
}
