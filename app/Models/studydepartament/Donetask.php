<?php

namespace App\Models\studydepartament;

use App\Models\admin\Department;
use App\Models\admin\SendTask;
use App\Models\studydepartament\DoneTaskHasFile;
use App\Models\faculty\Faculty;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function auth;

class Donetask extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'done_tasks';

    protected $fillable =
        [
            'user_id',
            'task_id',
            'faculty_id',
            'comment',
            'deadline',
            'status',
            'step',
            'report'
        ];

    public function files()
    {
        return $this->hasMany(DoneTaskHasFile::class, 'done_id', 'id');
    }

    public function taskname($id, $done)
    {
        $task = SendTask::find($id);
        $done = Donetask::find($done);
        $user = User::find($done->user_id);
        $department = Department::find($user->department_id);
        return $department;
    }

    public function sendtask($id)
    {
        $task = SendTask::find($id);
        return $task->title;
    }

    public function faculty($id)
    {
        $user_id = auth()->user()->id;
        $f_id = User::find($user_id)->faculty_id;
        $faculty = Faculty::find($f_id);

        return $faculty;
    }

    public function task()
    {
        return $this->belongsTo(SendTask::class, 'task_id', 'id');
    }

    public function departments($id)
    {
        $ids = DB::table('tasks_has_departments')->where('task_id', $id)->pluck('department_id');
        $d = Department::whereIn('id', $ids)->get();
        return $d;
    }

    public function single_department($id)
    {
        $done = Donetask::find($id);

        if (!$done) {
            return 'Donetask topilmadi';
        }

        $user = User::find($done->user_id);

        if (!$user) {
            return 'User topilmadi';
        }

        $task = SendTask::where('id', $done->task_id)->first();


        if (!$task) {
            return 'Mavjud emas';
        }

        $ids = DB::table('tasks_has_departments')
            ->where('task_id', $done->task_id)
            ->where('department_id', $user->department_id)
            ->first();

        if (!$ids) {
            return 'Department topilmadi';
        }

        $department = Department::find($ids->department_id);

        return $department->name ?? 'Department topilmadi';
    }

    public function checkdone($id)
    {
        $user = auth()->user();

        $done = Donetask::where('task_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($done) {
            return $done;
        } else {
            return false;
        }
    }


}
