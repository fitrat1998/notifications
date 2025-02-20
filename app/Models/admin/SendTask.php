<?php

namespace App\Models\admin;


use App\Models\documenttype\DocumentType;
use App\Models\studydepartament\Donetask;
use App\Models\User;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SendTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $softCascade = ['files'];

    protected $fillable = [
        'title',
        'user_id',
        'comment',
        'deadline',
        'process',
        'status',
        'set_status',
    ];

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'tasks_has_faculties', 'task_id', 'faculty_id');
    }

    public function files()
    {
        return $this->hasMany(TaskHasFile::class, 'task_id', 'id');
    }


    public function categories()
    {
        return $this->hasMany(Documenttype::class, 'task_id', 'id');
    }

    public function department($id)
    {
        $departmrnt = Department::find($id);
        return $departmrnt;
    }

    public function done()
    {
        return $this->hasOne(Donetask::class, 'task_id', 'id');
    }

    public function faculty($id)
    {
        $user_id = auth()->user()->id;
        $f_id = User::find($user_id)->faculty_id;
        $faculty = Faculty::find($f_id);

        return $faculty;
    }


    public function departments()
    {
        return $this->belongsToMany(Department::class, 'tasks_has_departments', 'task_id', 'department_id');
    }

    public function documenttype()
    {
        return $this->belongsToMany(DocumentType::class, 'tasks_has_departments', 'task_id', 'documenttype_id');
    }

    public function department_name($id)
    {
        $ids = DB::table('documenttypes_has_deparments')->where('documenttype_id', $id)->pluck('department_id');

        $data = Department::whereIn('id', $ids)->get();

        return $data;
    }


    public function checkdone($id)
    {
        $user = auth()->user();

        $done = Donetask::where('task_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($done) {
            return true;
        } else {
            return false;
        }
    }

    public function checkdeadline($id)
    {
        $sendTask = SendTask::find($id);
        $deadline = Carbon::parse($sendTask->deadline);
        $today = Carbon::now();
        $daysDifference = $today->diffInDays($deadline, false); // False - kunlar manfiy bo'lsa ko'rsatadi
        return $daysDifference;
    }



    public function check_done($id)
    {
//        $sendTask = SendTask::find($id);

        $user = auth()->user();

        $done = Donetask::where('task_id', $id)
            ->where('user_id', $user->id)
            ->first();

//        return $id;

        if ($done) {
            return $done;
        } else {
            return false;
        }

    }

    public function unread($id)
    {
        $user = auth()->user()->department_id;

        $sendtask = DB::table('unread_departments')
            ->where('department_id', $user)
            ->where('task_id', $id)
            ->first();

        return $sendtask;
    }

    public function all_departments($id)
    {
        $departments_id = DB::table('unread_departments')
            ->where('task_id', $id)
            ->pluck('department_id');

        $departments = Department::whereIn('id', $departments_id)->get();

        return $departments;
    }

    public function unread_departments($id)
    {
        $departments_id = DB::table('unread_departments')
            ->where('task_id', $id)
            ->where('status', 'unread')
            ->pluck('department_id');

        $departments = Department::whereIn('id', $departments_id)->get();

        return $departments;
    }

    public function read_departments($id)
    {
        $departments_id = DB::table('unread_departments')
            ->where('task_id', $id)
            ->where('status', 'unread')
            ->pluck('department_id');

        $departments = Department::whereIn('id', $departments_id)->get();

        return $departments;
    }

    public function status_read_or_unread($id)
    {
        $status = DB::table('unread_departments')
            ->where('task_id', $id)
            ->get();

        return $status;
    }


    public function single_department($id)
    {
        $department = Department::find($id);

        return $department;
    }

    public function accepted_department($id)
    {
        $departments_id = DB::table('tasks_has_departments')
            ->where('task_id', $id)
            ->where('status', 'accepted')
            ->pluck('department_id');

        $departments = Department::whereIn('id', $departments_id)->get();

        return $departments;
    }

    public function expired_department($id)
    {
        $task_ids = DB::table('tasks_has_departments')
            ->where('task_id', $id)
            ->where('status', 'waiting')
            ->distinct()
            ->pluck('task_id');

        $sendtask = SendTask::whereIn('id', $task_ids)
            ->where('created_at', '<', now())
            ->first();

        if ($sendtask) {
            $departments_id = DB::table('tasks_has_departments')
                ->where('task_id', $sendtask->id)
                ->where('status', 'waiting')
                ->pluck('department_id');

            $departments = Department::whereIn('id', $departments_id)->get();

            return $departments;
        } else {
            return [0];
        }

    }


}
