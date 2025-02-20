<?php

namespace App\Http\Controllers;

use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\UserDocuments;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilteredPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function filtered_status_tasks()
    {

        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->groupBy('task_id')
            ->pluck('task_id');

        $tasks = SendTask::whereIn('id', $departments)->get();

        return view('admin.tasks.status_tasks', compact('tasks'));
    }

    public function filtered_unread()
    {

        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->where('status', 'unread')
            ->groupBy('task_id')
            ->pluck('task_id');


        $tasks = SendTask::whereIn('id', $departments)->get();

        return view('admin.tasks.unread', compact('tasks'));
    }


    public function filtered_read()
    {

        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->where('status', 'read')
            ->groupBy('task_id')
            ->pluck('task_id');


        $tasks = SendTask::whereIn('id', $departments)->get();

        return view('admin.tasks.read', compact('tasks'));
    }


    public function filtered_expired(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start_date = $start_date ? Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $end_date = $end_date ? Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay() : Carbon::now()->endOfDay();


        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->where('status', 'unread')
            ->groupBy('task_id')
            ->pluck('task_id');


        $tasks = SendTask::whereIn('id', $departments)
            ->where('deadline', '<', $start_date)
            ->get();

        return view('admin.tasks.expired', compact('tasks'));
    }

    public function filtered_deadlinelessleft(Request $request)
    {


        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start_date = $start_date ? Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $end_date = $end_date ? Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay() : Carbon::now()->endOfDay();

        $today = Carbon::today();
        $threeDaysLater = $today->copy()->addDays(3);

        $today = Carbon::today();
        $threeDaysLater = $today->copy()->addDays(3);

        $departments = DB::table('tasks_has_departments')
            ->select('task_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'waiting')
            ->groupBy('task_id')
            ->havingRaw('COUNT(*) = (SELECT COUNT(*) FROM tasks_has_departments AS thd WHERE thd.task_id = tasks_has_departments.task_id AND thd.status = "waiting")')
            ->pluck('task_id');


        $tasks = SendTask::whereIn('id', $departments)
            ->whereBetween('deadline', [$start_date, $end_date])
            ->get();


//        dd($tasks);


        return view('admin.tasks.deadlinelessleft', compact('tasks'));
    }

    public function filtered_accepted_departments(Request $request)
    {

        $accept = DB::table('tasks_has_departments')
            ->where('status', 'accepted')
            ->get();

        $today = Carbon::today();
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start_date = $start_date ? Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $end_date = $end_date ? Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay() : Carbon::now()->endOfDay();

        $accepted_task_id = DB::table('tasks_has_departments as thd')
            ->select('thd.task_id')
            ->where('thd.status', 'accepted')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('tasks_has_departments as sub_thd')
                    ->whereColumn('sub_thd.task_id', 'thd.task_id')
                    ->where('sub_thd.status', 'waiting');
            })
            ->groupBy('thd.task_id')
            ->havingRaw('COUNT(*) = (SELECT COUNT(*) FROM tasks_has_departments WHERE task_id = thd.task_id)')
            ->pluck('task_id');

        $accepted = SendTask::whereIn('id', $accepted_task_id)
            ->whereBetween('deadline', [$start_date, $end_date])
            ->get();


//        return $accepted;

        return view('admin.tasks.accepted', compact('accepted', 'accept'));

    }

    public function filtered_accepted_userdocs(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');


        $start_date = $start_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $start_date)->format('Y-m-d') : \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date = $end_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $end_date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d');

        $accepted_ids = DB::table('userdocs_has_departments')
            ->select('userdocs_id')
            ->groupBy('userdocs_id')
            ->havingRaw('COUNT(CASE WHEN status != "accepted" THEN 1 END) = 0')
            ->pluck('userdocs_id');

        $accepted_userdocs = UserDocuments::whereIn('id', $accepted_ids)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        return view('admin.userdocs.accepted', compact('accepted_userdocs'));
    }

    public function filtered_waiting_userdocs(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');


        $start_date = $start_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $start_date)->format('Y-m-d') : \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date = $end_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $end_date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d');

        $waiting_ids = DB::table('userdocs_has_departments')
            ->select('userdocs_id')
            ->groupBy('userdocs_id')
            ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) = 0')
            ->pluck('userdocs_id');

        $waiting_userdocs = UserDocuments::whereIn('id', $waiting_ids)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        return view('admin.userdocs.waiting', compact('waiting_userdocs'));
    }

    public function filtered_cancelled_userdocs(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');


        $start_date = $start_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $start_date)->format('Y-m-d') : \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date = $end_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $end_date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d');

        $cancelled_userdocs = UserDocuments::where('status', 'cancelled')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $user_ids = $cancelled_userdocs->pluck('cancelled_user');

        $users = User::whereIn('id', $user_ids)
            ->get();


        return view('admin.userdocs.cancelled', compact('cancelled_userdocs', 'users'));

    }

    public function filtered_mix_userdocs(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');


        $start_date = $start_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $start_date)->format('Y-m-d') : \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $end_date = $end_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $end_date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d');

        $all_ids = DB::table('userdocs_has_departments')
            ->select('userdocs_id')
            ->groupBy('userdocs_id')
            ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) > 0')
            ->havingRaw('COUNT(CASE WHEN status = "accepted" THEN 1 END) > 0')
            ->pluck('userdocs_id');

        $mix_userdocs = UserDocuments::whereIn('id', $all_ids)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();


        return view('admin.userdocs.mix', compact('mix_userdocs'));
    }

    public function filtered_all_userdocs(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $userdocs = UserDocuments::whereBetween('created_at', [$startDate, $endDate])->get();

//        dd($userdocs);

        return view('admin.userdocs.index', compact('userdocs'));
    }


    public function filtered_cancelled_done(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $send = Donetask::where('status', 'waiting')->get();

        $accepted = Donetask::where('status', 'accepted')->get();

        $cancelled = Donetask::where('status', 'cancelled')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->get();

        return view('admin.notifications.cancelled', compact('send', 'cancelled', 'accepted'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
