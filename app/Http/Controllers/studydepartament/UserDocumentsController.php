<?php

namespace App\Http\Controllers\studydepartament;

use App\Http\Controllers\Controller;
use App\Http\Requests\studydepartament\StoreUserDocumentsRequest;
use App\Http\Requests\studydepartament\UpdateUserDocumentsRequest;
use App\Models\admin\Department;
use App\Models\admin\SendTask;
use App\Models\documenttype\DocumentType;
use App\Models\Release;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\UserDocuments;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $d = DB::table('documenttypes_has_deparments')->where('department_id', $user->department_id)->pluck('documenttype_id');

        $documents = UserDocuments::where('user_id', $user->id)->get();

        $tasks = SendTask::all();

        $user_id = auth()->user()->id;

        $sendArray = [];

        $s = 0;

        $department_id = auth()->user()->department_id;
        $sends = [];


        return view('studydepartments.documents.index', compact('documents'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Department::all();

        $user = auth()->user();

        $d = DB::table('documenttypes_has_deparments')->where('department_id', $user->department_id)->pluck('documenttype_id');

        $documents = DocumentType::whereIn('id', $d)->get();

//        return $user->department_id;


        $department_id = DB::table('tasks_has_departments')
            ->where('department_id', $user->department_id)
            ->where('status', 'waiting')
            ->pluck('task_id');

//        return $department_id;


        $tasks = SendTask::where('status', 'waiting')
            ->whereIn('id', $department_id)
            ->get();

        return view('studydepartments.documents.done', compact('tasks', 'documents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserDocumentsRequest $request)
    {
        $user = auth()->user();


        $doctypes = UserDocuments::where('user_id', $user->id)->pluck('documenttype_id');

        if ($request->file('files')) {
            $create = UserDocuments::create([
                'documenttype_id' => $request->documenttype_id,
                'user_id' => $user->id,
                'comment' => $request->comment,
                'deadline' => now(),
                'status' => "waiting",
                'cancelled_user' => 0,
                'report' => 'empty',
            ]);

            $task_id = $request->documenttype_id;

            $departments = DB::table('confirm_departments_map')
                ->where('documenttype_id', $request->documenttype_id)
                ->pluck('department_id');

//            dd($departments);

            foreach ($departments as $d) {

                DB::table('userdocs_has_departments')->insert([
                    'userdocs_id' => $create->id,
                    'department_id' => $d,
                    'status' => 'waiting',
                ]);
            }

            foreach ($request->file('files') as $file) {

                $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $filePath = public_path('storage/usersenddocs/' . $name);
                $file->move(public_path('storage/usersenddocs'), $name);

                DB::table('userdocs_has_files')->insert([
                    'documenttype_id' => $task_id,
                    'userdocs_id' => $create->id,
                    'name' => $name,
                    'title' => $file->getClientOriginalName(),
                    'created_at' => NOW(),
                ]);
            }
        } else {
            $create = UserDocuments::create([
                'documenttype_id' => $request->documenttype_id,
                'user_id' => $user->id,
                'comment' => $request->comment,
                'deadline' => now(),
                'status' => "waiting",
                'cancelled_user' => 0,
                'report' => 'empty',
            ]);

            $task_id = $request->documenttype_id;

            $departments = DB::table('confirm_departments_map')
                ->where('documenttype_id', $request->documenttype_id)
                ->pluck('department_id');

//             dd($departments);

            foreach ($departments as $d) {

                DB::table('userdocs_has_departments')->insert([
                    'userdocs_id' => $create->id,
                    'department_id' => $d,
                    'status' => 'waiting',
                ]);
            }


        }


        return redirect()->route('userdocuments.index')->with('success', 'Hujjat muvaffaqiyatli yaratildi');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $document = DoneUserDocs::where('userdocs_id', $id)->get();
        $users_ids = $document->pluck('user_id');

        $users = User::whereIn('id', $users_ids)
            ->select('id', 'firstname', 'lastname', 'middlename')
            ->get();

        $pdf_author = auth()->user()->id;

        $userdocument = UserDocuments::findOrFail($id);
        $author = User::findOrFail($userdocument->user_id);

        $documenttype_id = $userdocument->documenttype_id;
        $documenttype = DocumentType::findOrFail($documenttype_id);

        $existingRelease = Release::where('document_id', $userdocument->id)
            ->where('user_id', $pdf_author)
            ->where('documenttype_id', $documenttype_id)
            ->latest()
            ->first();

        $userdocument = UserDocuments::findOrFail($id);

        // PDF yaratish
        $pdf = Pdf::loadView('studydepartments.documents.show', [
            'userdocument' => $userdocument,
            'author' => $author ?? null,
            'users' => $users ?? null,
            'documenttype' => $documenttype ?? null
        ])
            ->setPaper('A4', 'portrait');

        // ✅ Unicode shriftni ishlatish (Foydalanuvchi ma'lumotlari uchun to‘g‘ri ko‘rinadi)
        $pdf->getDomPDF()->set_option("defaultFont", "dejavu sans");

        // PDF fayl nomini yaratish (unikal qilish)
        $pdfFileName = storage_path('app/pdfs/' . hash('sha256', $id . 'hujjat') . '.pdf');

        // Agar katalog mavjud bo‘lmasa, uni yaratamiz
        if (!File::exists(storage_path('app/pdfs'))) {
            File::makeDirectory(storage_path('app/pdfs'), 0775, true);
        }

        // ❌ PDF'ni saqlash (agar kerak bo‘lsa)
        // $pdf->save($pdfFileName);

        // ✅ PDF'ni brauzerda ochish
        return $pdf->stream('document.pdf');


//    $document = UserDocuments::find($id);
//
////    dd($document);
//
//    // You can pass the document data to the view for PDF rendering
//    $pdf = Pdf::loadView('studydepartments.documents.show', compact('document'));
//
//    // Return the PDF as a response to be downloaded by the user
//    return $pdf->stream('document.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $userdoc = UserDocuments::find($id);

        $user = auth()->user();

        $d = DB::table('documenttypes_has_deparments')->where('department_id', $user->department_id)->pluck('documenttype_id');

        $documents = DocumentType::whereIn('id', $d)->get();

        $department_id = DB::table('tasks_has_departments')
            ->where('department_id', $user->department_id)
            ->where('status', 'waiting')
            ->pluck('task_id');


//        return $documents;

        return view('studydepartments.documents.edit', compact('documents', 'userdoc'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserDocumentsRequest $request, $id)
    {
        $update = UserDocuments::find($id);

        $up = $update->update([
            'documenttype_id' => $request->documenttype_id,
            'comment' => $request->comment,
            'deadline' => now(),
            'updated_at' => NOW(),
        ]);


        $departments = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $update->id)
//            ->get();
            ->pluck('department_id');

//                    dd($departments);


        if (!empty($request->documenttype_id)) {

            $existingdepartments = DB::table('userdocs_has_departments')
                ->whereIn('department_id', $departments)
                ->where('deleted_at', '')
                ->get();


            if ($existingdepartments) {
                foreach ($existingdepartments as $existingdepartment) {
                    $dl = DB::table('userdocs_has_departments')
                        ->where('department_id', $existingdepartment->department_id)
                        ->delete();
                }
            }


            if (!empty($request->documenttype_id)) {
                $departments = DB::table('confirm_departments_map')
                    ->where('documenttype_id', $update->documenttype_id)
                    ->pluck('department_id');

                if ($departments) {
                    foreach ($departments as $d) {
                        DB::table('userdocs_has_departments')->insert([
                            'userdocs_id' => $update->id,
                            'department_id' => $d,
                        ]);
                    }
                }
            }
        }

//here the last line i have done

        if ($request->hasFile('files')) {

            $existingFiles = DB::table('userdocs_has_files')
                ->where('userdocs_id', $update->id)
                ->get();

            foreach ($existingFiles as $existingFile) {
                Storage::delete('storage/usersenddocs/' . $existingFile->name);
                $d = DB::table('userdocs_has_files')
                    ->where('userdocs_id', $update->id)
                    ->where('name', $existingFile->name)
                    ->delete();
            }

            $files = $request->file('files.*');

            foreach ($files as $file) {

                $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $filePath = public_path('storage/usersenddocs/' . $name);
                $file->move(public_path('storage/usersenddocs/'), $name);

                DB::table('userdocs_has_files')->insert([
                    'userdocs_id' => $update->id,
                    'name' => $name,
                    'title' => $file->getClientOriginalName(),
                ]);
            }

        }

        return redirect()->route('userdocuments.index')->with('success', 'Topshiriq muvaffaqiyatli tahrirlandi');

    }

    public function download($filename)
    {
        $filePath = public_path('storage/usersenddocs/' . $filename);

//        dd($filePath);

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
        $deletes = DB::table('userdocs_has_files')->where('userdocs_id', $id)->get();

        foreach ($deletes as $d) {
            $f = Storage::delete('storage/usersenddocs//' . $d->name);
            if ($f) {
                echo "Fayl muvaffaqiyatli o'chirildi: " . $d->name;
            } else {
                echo "Fayl o'chirishda xatolik yuz berdi: " . $d->name;
            }
        }


        $deparments = DB::table('userdocs_has_departments')->where('userdocs_id', $id)->delete();


        UserDocuments::find($id)->delete();

        return redirect()->route('userdocuments.index')->with('success', 'Topshiriq muvaffaqiyatli o`chirildi');

    }

}
