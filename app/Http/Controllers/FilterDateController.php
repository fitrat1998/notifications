<?php

namespace App\Http\Controllers;

use App\Models\admin\Department;
use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\UserDocuments;
use Carbon\Carbon;
use http\Client\Curl\User;
use App\Models\User as Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = auth()->user()->roles[0]->name;
        $user = auth()->user();


        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        try {
            if ($startDate) {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->toDateString();
            }
        } catch (\Exception $e) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
        }

        try {
            if ($endDate) {
                $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->toDateString();
            }
        } catch (\Exception $e) {
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }

        $today = Carbon::today();

        if (!$startDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
        }

        if (!$endDate) {
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }


        if ($role == "Super Admin") {
            $departments_count = Department::count();
            $users_count = Users::where('id', '!=', 1)->count();

            $departments = DB::table('tasks_has_departments')
                ->select('task_id', DB::raw('COUNT(*) as total'))
                ->where('status', 'waiting')
                ->groupBy('task_id')
                ->get();

            $departments_id = $departments->pluck('task_id');

            $undonetasks_count = SendTask::whereIn('id', $departments_id)
                ->whereBetween('deadline', [$startDate, $endDate])
                ->count();

            $unread_count = SendTask::whereIn('id', $departments_id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');


            $today = Carbon::today();
            $threeDaysLater = Carbon::parse($endDate)->addDays(3);

            $departments = DB::table('tasks_has_departments')
                ->select('task_id', DB::raw('COUNT(*) as total'))
                ->where('status', 'waiting')
                ->groupBy('task_id')
                ->havingRaw('COUNT(*) = (SELECT COUNT(*) FROM tasks_has_departments AS thd WHERE thd.task_id = tasks_has_departments.task_id AND thd.status = "waiting")')
                ->pluck('task_id');


            $deadlinelessleft = SendTask::whereIn('id', $departments)
                ->where('deadline', '>=', $endDate)
                ->where(function ($query) use ($endDate, $threeDaysLater) {
                    $query->whereBetween('deadline', [$endDate, $threeDaysLater]);
                })
                ->count();


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
                ->whereBetween('deadline', [$startDate, $endDate])
                ->count();

//        dd($accepted);

            $cancelled = Donetask::where('status', 'cancelled')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $waiting = DB::table('tasks_has_departments')
                ->select('task_id')
                ->groupBy('task_id')
                ->havingRaw('SUM(CASE WHEN status = "waiting" THEN 1 ELSE 0 END) = COUNT(*)')
                ->count();

            $userdocs = UserDocuments::whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $accepted_ids = DB::table('userdocs_has_departments')
                ->select('userdocs_id')
                ->groupBy('userdocs_id')
                ->havingRaw('COUNT(CASE WHEN status != "accepted" THEN 1 END) = 0')
                ->pluck('userdocs_id');

            $waiting_ids = DB::table('userdocs_has_departments')
                ->select('userdocs_id')
                ->groupBy('userdocs_id')
                ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) = 0')
                ->pluck('userdocs_id');

            $all_ids = DB::table('userdocs_has_departments')
                ->select('userdocs_id')
                ->groupBy('userdocs_id')
                ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) > 0')
                ->havingRaw('COUNT(CASE WHEN status = "accepted" THEN 1 END) > 0')
                ->pluck('userdocs_id');

            $accepted_userdocs = UserDocuments::whereIn('id', $accepted_ids)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

//        dd($accepted_userdocs);

            $waiting_userdocs = UserDocuments::whereIn('id', $waiting_ids)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $mix_userdocs = UserDocuments::whereIn('id', $all_ids)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $cancelled_userdocs = UserDocuments::where('status', 'cancelled')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $expired_id = DB::table('tasks_has_departments')
                ->select('task_id')
                ->where('status', 'waiting')
                ->groupBy('task_id')
                ->pluck('task_id');

            $today = now()->toDateString();

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');


            $expired = SendTask::whereIn('id', $expired_id)
                ->whereDate('deadline', '<', $startDate)
                ->count();

//            dd($expired);


            return view('admin.filtered', compact(
                'departments_count',
                'users_count',
                'undonetasks_count',
                'deadlinelessleft',
                'accepted',
                'cancelled',
                'waiting',
                'unread_count',
                'userdocs',
                'waiting_userdocs',
                'accepted_userdocs',
                'cancelled_userdocs',
                'mix_userdocs',
                'expired'
            ));
        }
        // boshqa foydalanuvchilar uchun ham sanalarni ishlatib ma'lumotlarni filtrlash
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
