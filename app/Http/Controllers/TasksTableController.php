<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTasksTableRequest;
use App\Http\Requests\UpdateTasksTableRequest;
use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use App\Models\TasksTable;
use Illuminate\Support\Facades\DB;

class TasksTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = SendTask::all();

        $user = auth()->user();

        $ids = DB::table('tasks_has_departments')
//            ->where('user_id', $user->id ?? 0)
            ->pluck('task_id');

        $sends = SendTask::whereIn('id', $ids)->get();

        $sends_id = $sends->pluck('id')->toArray();

        $done = Donetask::whereIn('task_id', $sends_id)->pluck('task_id')->toArray();

        $count = SendTask::whereNotIn('id', $done)->count();

        $accepted = '';

        $cancelled = '';

        $tasks = $sends;

        $documents = '';


        return view('studydepartments.tasks.table-task', compact('sends', 'count'));

    }

    public function expired()
    {
        $tasks = SendTask::all();

        $user = auth()->user();
        $ids = DB::table('tasks_has_departments')
            ->where('status', 'waiting')
            ->groupBy('task_id') // Task ID'larni guruhlash
            ->pluck('task_id'); // Faqat distinct ID'larni olish

        $today = \Carbon\Carbon::today()->format('Y-m-d');

        $done = Donetask::all()->pluck('task_id')->toArray();

        $sends = SendTask::whereIn('id', $ids)
//            ->whereNotIn('id', $done)
            ->where('deadline', '<>', '0')
            ->whereDate('deadline', '<', $today)
            ->get();


        $sends_id = $sends->pluck('id')->toArray();

        $done = Donetask::whereIn('task_id', $sends_id)->pluck('task_id')->toArray();

        $count = SendTask::whereNotIn('id', $done)->count();

        $accepted = '';

        $cancelled = '';

        $tasks = $sends;

        $documents = '';


        return view('studydepartments.tasks.expired', compact('sends', 'count'));
    }

    public function waiting()
    {
        $tasks = SendTask::all();

        $user = auth()->user();

        $ids = DB::table('tasks_has_departments')
            ->where('status', 'waiting')
            ->pluck('task_id');

        $sends = SendTask::whereIn('id', $ids)
            ->where('deadline',0)
            ->get();

        $sends_id = $sends->pluck('id')->toArray();

        $done = Donetask::whereIn('task_id', $sends_id)->pluck('task_id')->toArray();

        $count = SendTask::whereNotIn('id', $done)->count();

        $accepted = '';

        $cancelled = '';

        $tasks = $sends;

        $documents = '';


        return view('studydepartments.tasks.waiting', compact('sends', 'count'));
    }

    public function done_list()
    {
        $tasks = SendTask::all();

        $user = auth()->user();

        $ids = DB::table('tasks_has_departments')
//            ->where('user_id', $user->id ?? 0)
            ->pluck('task_id');

        $sends = SendTask::whereIn('id', $ids)->get();

        $sends_id = $sends->pluck('id')->toArray();

        $done = Donetask::whereIn('task_id', $sends_id)
            ->where('user_id', $user->id)
            ->get();

        return view('studydepartments.tasks.done_list', compact('done'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 1;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTasksTableRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public
    function show(TasksTable $tasksTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(TasksTable $tasksTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(UpdateTasksTableRequest $request, TasksTable $tasksTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(TasksTable $tasksTable)
    {
        //
    }
}
