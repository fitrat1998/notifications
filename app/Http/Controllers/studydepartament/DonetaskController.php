<?php

namespace App\Http\Controllers\studydepartament;

use App\Http\Controllers\Controller;
use App\Http\Requests\faculty\StoreDonetaskRequest;
use App\Http\Requests\faculty\UpdateDonetaskRequest;
use App\Models\admin\Department;
use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function auth;
use function redirect;
use function view;

class DonetaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department_id = auth()->user()->department_id;

        $tasks = DB::table('tasks_has_departments')->where('department_id', $department_id)->pluck('task_id');

        $donetasks = Donetask::whereIn('task_id', $tasks)
            ->where('user_id', auth()->user()->id)
            ->get();


        return view('studydepartments.tasks.table-task', compact('donetasks', 'department_id'));
    }

    public function view($id)
    {
        $done = Donetask::where('task_id', $id)->first();

        return view('studydepartments.tasks.list', compact('done'));
    }

    public function process()
    {
        return view('faculty.tasks.process');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {


        $categories = Department::all();

        $user_id = auth()->user()->department_id;

        $department_id = DB::table('tasks_has_departments')
            ->where('department_id', $user_id)
            ->where('status', 'waiting')
            ->pluck('task_id');


        $tasks = SendTask::where('status', 'waiting')
            ->whereIn('id', $department_id)
            ->get();


        return view('studydepartments.tasks.done', compact('task'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDonetaskRequest $request)
    {

        $validated = $request->validated();


        $user = auth()->user();

        $exists = Donetask::where('task_id', intval($validated['task_id']))
            ->where('user_id', $user->id)
            ->first();

        if ($exists) {
            return redirect()->back()->with('danger', 'Bu malumotlar allaqachon mavjud');

        } else {
            if ($request->file('files')) {
                $create = Donetask::create([
                    'task_id' => intval($validated['task_id']),
                    'user_id' => $user->id,
                    'comment' => $validated['comment'],
                    'deadline' => NOW(),
                    'status' => "waiting",
                    'step' => 0,
                    'report' => 'empty',
                ]);

                $department = DB::table('tasks_has_departments')
                    ->where('task_id', $validated['task_id'])
                    ->where('department_id', $user->department_id)
                    ->update([
                        'status' => 'accepted'
                    ]);

                $read = DB::table('unread_departments')
                    ->where('task_id', $validated['task_id'])
                    ->where('department_id', $user->department_id)
                    ->update([
                        'status' => 'read'
                    ]);

                $done = $create->id;

                $task_id = intval($validated['task_id']);

                foreach ($request->file('files') as $file) {

                    $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                    $filePath = public_path('storage/doneuploads/' . $name);
                    $file->move(public_path('storage/doneuploads'), $name);

                    DB::table('done_tasks_has_files')->insert([
                        'task_id' => $task_id,
                        'done_id' => $done,
                        'name' => $name,
                        'title' => $file->getClientOriginalName(),
                        'created_at' => NOW(),
                    ]);
                }
            } else {
                if ($request->task_id) {
                    $create = Donetask::create([
                        'task_id' => intval($validated['task_id']),
                        'user_id' => $user->id,
                        'comment' => $validated['comment'],
                        'deadline' => NOW(),
                        'status' => "waiting",
                        'step' => 0,
                        'report' => 'empty',
                    ]);

                    $department = DB::table('tasks_has_departments')
                        ->where('task_id', $validated['task_id'])
                        ->where('department_id', $user->department_id)
                        ->update([
                            'user_id' => $user->id,
                            'status' => 'accepted',
                            'updated_at' => NOW(),
                        ]);
                } else {
                    return redirect()->back()->with('danger', 'Hujjat turi mavjud emas');
                }
            }


//            else {
//                return redirect()->back()->with('danger', 'Fayl kiritilmagan');
//            }

        }

        return redirect()->route('tasktables.index')->with('success', 'Topshiriq muvaffaqiyatli yaratildi');
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {


        $id = $id;
        $categories = Department::all();

        $user_id = auth()->user();

        $department_id = DB::table('tasks_has_departments')
            ->where('department_id', $user_id->department_id)
            ->where('status', 'waiting')
            ->pluck('task_id');


        $tasks = SendTask::where('status', 'waiting')
            ->whereIn('id', $department_id)
            ->get();

        $task = SendTask::find($id);


        return view('studydepartments.tasks.done', compact('task', 'id'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edits($id, $page)
    {

        $user_id = auth()->user();


        $department_id = DB::table('tasks_has_departments')
            ->where('department_id', $user_id->department_id)
            ->pluck('task_id');


        $tasks = SendTask::where('status', 'waiting')
            ->whereIn('id', $department_id)
            ->get();

        if ($page === "tasktables") {

            $done = Donetask::where('task_id', $id)->first();
        } else {
            $done = Donetask::where('id', $id)->first();
        }

        $task = SendTask::find($id);

        return view('studydepartments.tasks.edit', compact('done', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDonetaskRequest $request, $id)
    {
        $validated = $request->validated();

        $user = auth()->user();

        $update = Donetask::find($id);

        $faculties = DB::table('tasks_has_faculties')
            ->where('done_id', $update->id)
            ->where('task_id', $update->task_id)
            ->get();


        $up = $update->update([
            'task_id' => intval($validated['task_id']),
            'user_id' => $user->id,
            'comment' => $validated['comment'],
            'deadline' => NOW(),
            'status' => "waiting",
            'step' => 0,
            'report' => 'empty',
        ]);

        if ($request->file('files')) {
            $existingFiles = DB::table('done_tasks_has_files')
                ->where('done_id', $update->id)
                ->where('task_id', $update->task_id)
                ->get();

            foreach ($existingFiles as $existingFile) {
                Storage::delete('storage/doneuploads/' . $existingFile->name);
                $d = DB::table('done_tasks_has_files')
                    ->where('done_id', $update->id)
                    ->where('task_id', $update->task_id)
                    ->where('name', $existingFile->name)
                    ->where('created_at', $existingFile->created_at)
                    ->delete();
            }

            $files = $request->file('files.*');

            foreach ($files as $file) {

                $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
                $filePath = public_path('storage/doneuploads/' . $name);
                $file->move(public_path('storage/doneuploads'), $name);

                DB::table('done_tasks_has_files')->insert([
                    'task_id' => $update->task_id,
                    'done_id' => $update->id,
                    'name' => $name,
                    'title' => $file->getClientOriginalName(),
                    'updated_at' => NOW(),
                ]);
            }
        }


        return redirect()->route('tasktables.index')->with('success', 'Topshiriq muvaffaqiyatli tahrirlandi');
    }

    public function download($filename)
    {
        $filePath = public_path('storage/doneuploads/' . $filename);

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
        $done = Donetask::find($id);
        $deletes = DB::table('done_tasks_has_files')->where('done_id', $id)->get();
        foreach ($deletes as $d) {
            $f = Storage::delete('doneuploads/' . $d->name);
            if ($f) {
                echo "Fayl muvaffaqiyatli o'chirildi: " . $d->name;
            } else {
                echo "Fayl o'chirishda xatolik yuz berdi: " . $d->name;
            }
        }

        $deleteT = DB::table('done_tasks_has_files')->where('done_id', $id)->delete();
        $deleteT = DB::table('tasks_has_faculties')->where('done_id', $id)->delete();


        DB::table('tasks_has_departments')
            ->where('task_id', $done->task_id)
            ->where('updated_at', $done->updated_at)
            ->update([
                'status' => 'waiting'
            ]);

        $done->delete();

        return redirect()->route('tasktables.index')->with('success', 'Topshiriq muvaffaqiyatli o`chirildi');

    }
}
