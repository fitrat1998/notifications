<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSendTaskRequest;
use App\Http\Requests\UpdateSendTaskRequest;
use App\Models\admin\Department;
use App\Models\admin\Faculty;
use App\Models\admin\SendTask;
use App\Models\documenttype\DocumentType;
use App\Models\studydepartament\UserDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SendTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        $tasks = SendTask::all();
        return view('admin.tasks.index', compact('tasks', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documenttypes = DocumentType::all();
        $categories = Department::all();
        $departments = Department::all();

        return view('admin.tasks.send-task', compact('departments', 'categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSendTaskRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();

        if ($request->deadline == null) {
            $create = SendTask::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'comment' => $validated['comment'],
                'deadline' => $request->deadline ?? 0,
                'status' => 'waiting',
                'set_status' => 'off',
            ]);
        } else {
            $create = SendTask::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'comment' => $validated['comment'],
                'deadline' => $request->deadline,
                'status' => 'waiting',
                'set_status' => 'on',
            ]);
        }

        $task_id = $create->id;

        if ($request->department_id[0] == "all_departments") {

            $departments = Department::all();
            foreach ($departments as $d) {
                DB::table('tasks_has_departments')->insert([
                    'task_id' => $task_id,
                    'department_id' =>  $d->id,
                    'status' => 'waiting',
                    'user_id' => 0,
                ]);
            }
        } else {
            $departments = $request->department_id;
            foreach ($departments as $d) {

                DB::table('tasks_has_departments')->insert([
                    'task_id' => $task_id,
                    'department_id' => $d,
                    'status' => 'waiting',
                    'user_id' => 0,
                ]);
            }
        }

        foreach ($departments as $d) {

            DB::table('unread_departments')->insert([
                'user_id' => $user->id,
                'task_id' => $task_id,
                'department_id' =>  $d->id,
                'status' => 'unread',
            ]);
        }


        if ($request->hasFile('files')) {


            $existingFiles = DB::table('tasks_has_files')
                ->where('task_id', $create->id)
                ->get();

            foreach ($existingFiles as $existingFile) {
                Storage::delete('senduploads/' . $existingFile->name);
                $d = DB::table('tasks_has_files')
                    ->where('task_id', $create->id)
                    ->where('name', $existingFile->name)
                    ->delete();
            }

            $files = $request->file('files.*');

            foreach ($files as $file) {

                $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $filePath = public_path('storage/senduploads/' . $name);
                $file->move(public_path('storage/senduploads'), $name);

                DB::table('tasks_has_files')->insert([
                    'task_id' => $create->id,
                    'name' => $name,
                    'title' => $file->getClientOriginalName(),
                ]);
            }

        }

        return redirect()->route('sendtask.index')->with('success', 'Topshiriq muvaffaqiyatli yaratildi');


    }


    public function read($id)
    {
        $user = auth()->user();

        $sendtask = DB::table('unread_departments')
            ->where('department_id', $user->department_id)
            ->where('task_id', $id);

        $sendtask->update([
            'status' => 'read',
            'created_at' => NOW(),
        ]);

        return redirect()->route('tasktables.index')->with('success', 'Topshiriq o`qilgan sifatida belgilandi');

    }



    /**
     * Display the specified resource.
     */
    public function show($send_Task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = SendTask::find($id);
        $documenttypes = DocumentType::all();
        $departments = Department::all();

        $department_ids = DB::table('tasks_has_departments')->where('task_id', $id)->pluck('department_id')->toArray();

        return view('admin.tasks.edit', compact('task', 'department_ids', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSendTaskRequest $request, $id)
    {
        $validated = $request->validated();

//        dd($request);
        $user = auth()->user();

        $update = SendTask::find($id);

        $faculties = DB::table('tasks_has_faculties')->where('task_id', $update->id)->get();

        if ($request->deadline == null) {
            $up = $update->update([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'comment' => $validated['comment'],
                'deadline' => $request->deadline ?? 0,
                'status' => 'waiting',
                'set_status' => 'off',
            ]);
        } else {
            $up = $update->update([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'comment' => $validated['comment'],
                'deadline' => $request->deadline,
                'status' => 'waiting',
                'set_status' => 'on',
            ]);
        }


        if (!empty($request->department_id)) {
            $existingdepartments = DB::table('tasks_has_departments')
                ->where('task_id', $update->id)
                ->get();

            $existingdepartments = DB::table('tasks_has_departments')
                ->where('task_id', $update->id)
                ->get();

            foreach ($existingdepartments as $existingdepartment) {
                $dl = DB::table('tasks_has_departments')
                    ->where('task_id', $update->id)
                    ->delete();
            }
            if (!empty($request->department_id)) {


                if ($request->department_id[0] == "all_departments") {

                    $departments = Department::all();
                    foreach ($departments as $d) {
                        DB::table('tasks_has_departments')->insert([
                            'task_id' => $update->id,
                            'department_id' => $d->id,
                            'status' => 'waiting',
                            'user_id' => 0,
                        ]);
                    }
                } else {
                    $departments = $request->department_id;
                    foreach ($departments as $d) {

                        DB::table('tasks_has_departments')->insert([
                            'task_id' => $update->id,
                            'department_id' =>  $d,
                            'status' => 'waiting',
                            'user_id' => 0,
                        ]);
                    }
                }
            }
        }

        if ($request->hasFile('files')) {


            $existingFiles = DB::table('tasks_has_files')
                ->where('task_id', $update->id)
                ->get();

            foreach ($existingFiles as $existingFile) {
                Storage::delete('senduploads/' . $existingFile->name);
                $d = DB::table('tasks_has_files')
                    ->where('task_id', $update->id)
                    ->where('name', $existingFile->name)
                    ->delete();
            }

            $files = $request->file('files.*');

            foreach ($files as $file) {

                $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $filePath = public_path('storage/senduploads/' . $name);
                $file->move(public_path('storage/senduploads'), $name);

                DB::table('tasks_has_files')->insert([
                    'task_id' => $update->id,
                    'name' => $name,
                    'title' => $file->getClientOriginalName(),
                ]);
            }

        }
        return redirect()->route('sendtask.index')->with('success', 'Topshiriq muvaffaqiyatli tahrirlandi');


    }

    public function download($filename)
    {
        $filePath = public_path('storage/senduploads/' . $filename);

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
        $deletes = DB::table('tasks_has_files')->where('task_id', $id)->get();

        foreach ($deletes as $d) {
            $f = Storage::delete('senduploads/' . $d->name);
            if ($f) {
                echo "Fayl muvaffaqiyatli o'chirildi: " . $d->name;
            } else {
                echo "Fayl o'chirishda xatolik yuz berdi: " . $d->name;
            }
        }


        $deparments = DB::table('tasks_has_departments')->where('task_id', $id)->delete();


//        DB::table('tasks_has_files')->where('task_id', $id)->delete();
//
        SendTask::find($id)->delete();
//
//
        return redirect()->route('sendtask.index')->with('success', 'Topshiriq muvaffaqiyatli o`chirildi');


    }

}
