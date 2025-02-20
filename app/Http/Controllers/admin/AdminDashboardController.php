<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\UserDocuments;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 1;
    }

    public function status_tasks()
    {
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();

        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->groupBy('task_id')
            ->pluck('task_id');

        $tasks = SendTask::whereIn('id', $departments)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('admin.tasks.status_tasks', compact('tasks'));
    }

    public function unread()
    {

        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();

        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->where('status', 'unread')
            ->groupBy('task_id')
            ->pluck('task_id');


        $tasks = SendTask::whereIn('id', $departments)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('admin.tasks.unread', compact('tasks'));
    }


    public function read()
    {
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();

        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->where('status', 'read')
            ->groupBy('task_id')
            ->pluck('task_id');


        $tasks = SendTask::whereIn('id', $departments)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('admin.tasks.read', compact('tasks'));
    }


    public function expired()
    {
        $today = Carbon::now()->format('Y-m-d');

        $departments = DB::table('tasks_has_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->where('status', 'waiting')
            ->groupBy('task_id')
            ->pluck('task_id');

        $tasks = SendTask::whereIn('id', $departments)
            ->whereDate('deadline', '<', $today) // 'whereDate' method is used to compare only the date part
            ->get();

//        dd($tasks);

        return view('admin.tasks.expired', compact('tasks'));
    }

    public function deadlinelessleft()
    {
        $today = Carbon::now()->format('Y-m-d');

        $departments = DB::table('unread_departments')
            ->select('task_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
            ->where('status', 'unread')
            ->groupBy('task_id')
            ->pluck('task_id');


        $tasks = SendTask::whereIn('id', $departments)
            ->where('deadline', '>=', Carbon::now()->addDays(3)->toDateString())
            ->get();

        return view('admin.tasks.deadlinelessleft', compact('tasks'));
    }

    public function accepted_departments()
    {

        $accept = DB::table('tasks_has_departments')
            ->where('status', 'accepted')
            ->get();

        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

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
            ->whereBetween('deadline', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->get();


        $task_ids = $accept->pluck('task_id');
        $department_ids = $accept->pluck('department_id');

        return view('admin.tasks.accepted', compact('accepted', 'accept'));

    }

    public function accepted_userdocs()
    {
        $accepted_ids = DB::table('userdocs_has_departments')
            ->select('userdocs_id')
            ->groupBy('userdocs_id')
            ->havingRaw('COUNT(CASE WHEN status != "accepted" THEN 1 END) = 0')
            ->pluck('userdocs_id');


        $accepted_userdocs = UserDocuments::whereIn('id', $accepted_ids)->get();

//        return $accepted_userdocs;

        return view('admin.userdocs.accepted', compact('accepted_userdocs'));


    }

    public function waiting_userdocs()
    {
        $waiting_ids = DB::table('userdocs_has_departments')
            ->select('userdocs_id')
            ->groupBy('userdocs_id')
            ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) = 0')
            ->pluck('userdocs_id');

        $waiting_userdocs = UserDocuments::whereIn('id', $waiting_ids)->get();


        return view('admin.userdocs.waiting', compact('waiting_userdocs'));
    }

    public function cancelled_userdocs()
    {
        $cancelled_userdocs = UserDocuments::where('status', 'cancelled')->get();

        $user_ids = $cancelled_userdocs->pluck('cancelled_user');

        $users = User::whereIn('id', $user_ids)->get();


        return view('admin.userdocs.cancelled', compact('cancelled_userdocs', 'users'));

    }

    public function mix_userdocs()
    {
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();

        $all_ids = DB::table('userdocs_has_departments')
            ->select('userdocs_id')
            ->groupBy('userdocs_id')
            ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) > 0')
            ->havingRaw('COUNT(CASE WHEN status = "accepted" THEN 1 END) > 0')
            ->pluck('userdocs_id');

        $mix_userdocs = UserDocuments::whereIn('id', $all_ids)
            ->whereBetween('deadline', [$startDate, $endDate])
            ->get();


        return view('admin.userdocs.mix', compact('mix_userdocs'));
    }

    public function all_userdocs()
    {
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();

        $userdocs = UserDocuments::whereBetween('created_at', [$startDate, $endDate])->get();


        return view('admin.userdocs.index', compact('userdocs'));
    }


    public function cancelled_done(Request $request)
    {
        $user = auth()->user();

        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->toDateString();

        $cancelled = Donetask::where('status', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('admin.notifications.cancelled', compact('cancelled'));

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
        echo "das";
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
