<?php

namespace App\Http\Controllers;

use App\Models\admin\Department;
use App\Models\admin\SendTask;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\UserDocuments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $role = auth()->user()->roles[0]->name;
        $user = auth()->user();

        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        if ($role == "Super Admin") {
            $departments_count = Department::count();
            $users_count = User::where('id', '!=', 1)->count();

            $departments = DB::table('tasks_has_departments')
                ->select('task_id', DB::raw('COUNT(*) as total'))
                ->where('status', 'waiting')
                ->groupBy('task_id')
                ->get();

            $departments_id = $departments->pluck('task_id');

            $undonetasks_count = SendTask::whereIn('id', $departments_id)
                ->whereBetween('deadline', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $unread_count = SendTask::whereIn('id', $departments_id)
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();


            $threeDaysLater = $today->copy()->addDays(3);

            $departments = DB::table('tasks_has_departments')
                ->select('task_id', DB::raw('COUNT(*) as total'))
                ->where('status', 'waiting')
                ->groupBy('task_id')
                ->havingRaw('COUNT(*) = (SELECT COUNT(*) FROM tasks_has_departments AS thd WHERE thd.task_id = tasks_has_departments.task_id AND thd.status = "waiting")')
                ->pluck('task_id');

            $deadlinelessleft = SendTask::whereIn('id', $departments)
                ->where('deadline', '>=', $today)
                ->where(function ($query) use ($today, $threeDaysLater) {
                    $query->orWhereBetween('deadline', [$today, $threeDaysLater]);
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
                ->whereBetween('deadline', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

//            dd($accepted_task_id);


            $cancelled = Donetask::where('status', 'cancelled')
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $waiting = DB::table('tasks_has_departments')
                ->select('task_id')
                ->groupBy('task_id')
                ->havingRaw('SUM(CASE WHEN status = "waiting" THEN 1 ELSE 0 END) = COUNT(*)')
                ->count();

            $userdocs = UserDocuments::whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
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
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();


            $waiting_userdocs = UserDocuments::whereIn('id', $waiting_ids)
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $mix_userdocs = UserDocuments::whereIn('id', $all_ids)
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $cancelled_userdocs = UserDocuments::where('status', 'cancelled')
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $expired_id = DB::table('tasks_has_departments')
                ->where('department_id', $user->department_id)
                ->where('status', 'waiting')
                ->pluck('task_id');

            $expired = SendTask::whereIn('id', $expired_id)
                ->whereDate('deadline', '>', $today)
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();


            return view('admin.index', compact(
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
            ));
        } else {

//            $ids = DB::table('tasks_has_departments')
//                ->where('department_id', $user->department_id)
//                ->pluck('task_id');
//
//            $sends = SendTask::whereIn('id', $ids)
////                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//                ->get();

            $userdocs_id = DB::table('userdocs_has_departments')
                ->select('userdocs_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
                ->where('status', 'waiting')
                ->where('department_id', $user->department_id)
                ->groupBy('userdocs_id')
                ->pluck('userdocs_id');

            $userdocs = UserDocuments::whereIn('id', $userdocs_id)
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $waiting = count($userdocs);

//            dd($user->department_id);

            $tasks = 0;

            $userdocs_accepted = DB::table('userdocs_has_departments')
                ->where('department_id', $user->department_id)
                ->where('status', 'accepted')
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $userdocs_cancelled = UserDocuments::where('status', 'cancelled')
                ->where('user_id', $user->id)
                ->where('cancelled_user', '!=', $user->id)
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $userdocs = DB::table('userdocs_has_departments')
                ->where(function ($query) {
                    $query->where('status', 'accepted')
                        ->orWhere('status', 'waiting');
                })
                ->get();

            $userdocs = DB::table('userdocs_has_departments')
                ->where(function ($query) {
                    $query->where('status', 'accepted')
                        ->orWhere('status', 'waiting');
                })
                ->get();

            $userdocs_grouped = $userdocs->groupBy('userdocs_id');

            $userdocs_waiting_ids = $userdocs_grouped->filter(function ($group) {
                $statuses = $group->pluck('status')->unique();
                return $statuses->contains('accepted') && $statuses->contains('waiting');
            })->keys();


            $waiting = UserDocuments::whereIn('id', $userdocs_waiting_ids)
                ->where('user_id', $user->id)
                ->count();

//            dd($userdocs_accepted);


            $userdocs = UserDocuments::where('user_id', $user->id)
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $accepted = count($userdocs_accepted);
            $accepted_ids = $userdocs_accepted->pluck('userdocs_id');
            $cancelled = count($userdocs_cancelled);
            $documents = count($userdocs);


            $created_ids = DB::table('userdocs_has_departments')
                ->where('department_id', $user->department_id)
                ->pluck('userdocs_id');


            $created_docs = UserDocuments::whereIn('id', $created_ids)
                ->where('user_id', '=', $user->id)
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $created_docs_count = count($created_docs);

            $created_docs_id = $created_docs->pluck('id');

            $accepted_docs = DoneUserDocs::whereIn('userdocs_id', $created_docs_id)
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();


//            dd($accepted_docs);

            $cancelled_docs = UserDocuments::where('user_id', $user->id)
                ->where('status', 'cancelled')
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $anotherdocs = UserDocuments::where('user_id', '!=', $user->id)
                ->pluck('id');

            $recived_docs_count = DB::table('userdocs_has_departments')
                ->where('department_id', $user->department_id)
                ->where('status', 'waiting')
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $accepted_my_docs = DB::table('userdocs_has_departments')
                ->where('department_id', $user->department_id)
//                ->whereIn('userdocs_id', $anotherdocs)
                ->where('status', 'accepted')
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $cancelled_my_docs = UserDocuments::where('cancelled_user', $user->id)
                ->where('status', 'cancelled')
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $accepted_my_tasks_id = DB::table('tasks_has_departments')
                ->where('department_id', $user->department_id)
                ->where('status', 'accepted')
                ->pluck('task_id');


            $waiting_my_tasks_id = DB::table('tasks_has_departments')
                ->where('department_id', $user->department_id)
                ->where('status', 'waiting')
                ->pluck('task_id');


            $accepted_my_tasks = SendTask::whereIn('id', $accepted_my_tasks_id)
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();


            $waiting_my_tasks = SendTask::whereIn('id', $waiting_my_tasks_id)
                ->whereDate('deadline', '<', $today)
//                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

            $expired_id = DB::table('tasks_has_departments')
                ->where('department_id', $user->department_id)
                ->where('status', 'waiting')
                ->pluck('task_id');

            $expired = SendTask::whereIn('id', $expired_id)
                ->whereDate('deadline', '>', $today)
                ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->count();

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

            return view('studydepartments.index', compact(
                'waiting',
                'accepted',
//                'my_accepted_docs_list',
                'accepted_ids',
                'cancelled',
                'documents',
                'created_docs_count',
                'accepted_docs',
                'cancelled_docs',
                'recived_docs_count',
                'accepted_my_docs',
                'cancelled_my_docs',
                'accepted_my_tasks',
                'waiting_my_tasks',
                'expired',
                'user_documents'
            ));
        }
    }

}

//<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\admin\Department;
//use App\Models\admin\SendTask;
//use App\Models\studydepartament\Donetask;
//use App\Models\studydepartament\DoneUserDocs;
//use App\Models\studydepartament\UserDocuments;
//use App\Models\User;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//use Carbon\Carbon;
//
//class HomeController extends Controller
//{
//   public function index()
//{
//    $role = auth()->user()->roles[0]->name;
//    $user = auth()->user();
//
//    $today = Carbon::today();
//    $startOfMonth = $today->copy()->startOfMonth();
//    $endOfMonth = $today->copy()->endOfMonth();
//
//    if ($role == "Super Admin") {
//        $departments_count = Department::count();
//        $users_count = User::where('id', '!=', 1)->count();
//
//        $departments = DB::table('tasks_has_departments')
//            ->select('task_id', DB::raw('COUNT(*) as total'))
//            ->where('status', 'waiting')
//            ->groupBy('task_id')
//            ->get();
//
//        $departments_id = $departments->pluck('task_id');
//
//        $undonetasks_count = SendTask::whereIn('id', $departments_id)
//            ->whereBetween('deadline', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $unread_count = SendTask::whereIn('id', $departments_id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $deadlinelessleft = SendTask::whereIn('id', $departments_id)
//            ->whereBetween('deadline', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $accepted = DB::table('tasks_has_departments')
//            ->where('status', 'accepted')
//            ->select('task_id')
//            ->groupBy('task_id')
//            ->count();
//
//        $cancelled = Donetask::where('status', 'cancelled')
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $waiting = DB::table('tasks_has_departments')
//            ->select('task_id')
//            ->groupBy('task_id')
//            ->havingRaw('SUM(CASE WHEN status = "waiting" THEN 1 ELSE 0 END) = COUNT(*)')
//            ->count();
//
//        $userdocs = UserDocuments::whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $accepted_ids = DB::table('userdocs_has_departments')
//            ->select('userdocs_id')
//            ->groupBy('userdocs_id')
//            ->havingRaw('COUNT(CASE WHEN status != "accepted" THEN 1 END) = 0')
//            ->pluck('userdocs_id');
//
//        $waiting_ids = DB::table('userdocs_has_departments')
//            ->select('userdocs_id')
//            ->groupBy('userdocs_id')
//            ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) = 0')
//            ->pluck('userdocs_id');
//
//        $all_ids = DB::table('userdocs_has_departments')
//            ->select('userdocs_id')
//            ->groupBy('userdocs_id')
//            ->havingRaw('COUNT(CASE WHEN status != "waiting" THEN 1 END) > 0')
//            ->havingRaw('COUNT(CASE WHEN status = "accepted" THEN 1 END) > 0')
//            ->pluck('userdocs_id');
//
//        $accepted_userdocs = UserDocuments::whereIn('id', $accepted_ids)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//        $waiting_userdocs = UserDocuments::whereIn('id', $waiting_ids)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//        $mix_userdocs = UserDocuments::whereIn('id', $all_ids)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//        $cancelled_userdocs = UserDocuments::where('status', 'cancelled')
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        return view('admin.index', compact(
//            'departments_count',
//            'users_count',
//            'undonetasks_count',
//            'deadlinelessleft',
//            'accepted',
//            'cancelled',
//            'waiting',
//            'unread_count',
//            'userdocs',
//            'waiting_userdocs',
//            'accepted_userdocs',
//            'cancelled_userdocs',
//            'mix_userdocs'
//        ));
//    } else {
//        $ids = DB::table('tasks_has_departments')->where('department_id', $user->department_id)->pluck('task_id');
//        $sends = SendTask::whereIn('id', $ids)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->get();
//
//        $userdocs_id = DB::table('userdocs_has_departments')
//            ->select('userdocs_id', DB::raw('GROUP_CONCAT(department_id) as departments'))
//            ->where('status', 'waiting')
//            ->where('department_id', $user->department_id)
//            ->groupBy('userdocs_id')
//            ->pluck('userdocs_id');
//
//        $userdocs = UserDocuments::whereIn('id', $userdocs_id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->get();
//
//        $waiting = count($userdocs);
//
//        $tasks = 0;
//
//        $userdocs_accepted = DB::table('userdocs_has_departments')
//            ->where('department_id', $user->department_id)
//            ->where('status', 'accepted')
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->get();
//
//        $userdocs_cancelled = UserDocuments::where('status', 'cancelled')
//            ->where('user_id', $user->id)
//            ->where('cancelled_user', '!=', $user->id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->get();
//
//        $userdocs = UserDocuments::where('user_id', $user->id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->get();
//
//        $accepted = count($userdocs_accepted);
//        $cancelled = count($userdocs_cancelled);
//        $waiting = count($sends);
//        $documents = count($userdocs);
//
//        $created_ids = DB::table('userdocs_has_departments')->where('department_id', $user->department_id)->pluck('userdocs_id');
//        $created_docs = UserDocuments::whereIn('id', $created_ids)
//            ->where('user_id', $user->id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->get();
//
//        $created_docs_count = count($created_docs);
//        $created_docs = UserDocuments::where('user_id', $user->id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->get();
//        $created_docs_count = count($created_docs);
//        $created_docs_id = $created_docs->pluck('id');
//
//        $accepted_docs = DoneUserDocs::whereIn('userdocs_id', $created_docs_id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $cancelled_docs = UserDocuments::where('user_id', $user->id)
//            ->where('status', 'cancelled')
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $anotherdocs = UserDocuments::where('user_id', '!=', $user->id)
//            ->pluck('id');
//
//        $recived_docs_count = DB::table('userdocs_has_departments')
//            ->where('department_id', $user->department_id)
//            ->where('status', 'waiting')
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $accepted_my_docs = DB::table('userdocs_has_departments')
//            ->where('department_id', $user->department_id)
//            ->whereIn('userdocs_id', $anotherdocs)
//            ->where('status', 'accepted')
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $cancelled_my_docs = UserDocuments::where('cancelled_user', $user->id)
//            ->where('status', 'cancelled')
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $accepted_my_tasks_id = DB::table('tasks_has_departments')
//            ->where('department_id', $user->department_id)
//            ->where('status', 'accepted')
//            ->pluck('task_id');
//
//        $waiting_my_tasks_id = DB::table('tasks_has_departments')
//            ->where('department_id', $user->department_id)
//            ->where('status', 'waiting')
//            ->pluck('task_id');
//
//        $accepted_my_tasks = SendTask::whereIn('id', $accepted_my_tasks_id)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//        $waiting_my_tasks = SendTask::whereIn('id', $waiting_my_tasks_id)
//            ->whereDate('deadline', '<', $today)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        $expired_id = DB::table('tasks_has_departments')
//            ->where('department_id', $user->department_id)
//            ->where('status', 'waiting')
//            ->pluck('task_id');
//
//        $expired = SendTask::whereIn('id', $expired_id)
//            ->whereDate('deadline', '>', $today)
//            ->whereBetween('created_at', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
//            ->count();
//
//        return view('studydepartments.index', compact(
//            'waiting',
//            'accepted',
//            'cancelled',
//            'documents',
//            'created_docs_count',
//            'accepted_docs',
//            'cancelled_docs',
//            'recived_docs_count',
//            'accepted_my_docs',
//            'cancelled_my_docs',
//            'accepted_my_tasks',
//            'waiting_my_tasks',
//            'expired'
//        ));
//    }
//}
//
//
//
//}
//
//
//
