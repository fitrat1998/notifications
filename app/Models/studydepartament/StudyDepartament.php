<?php

namespace App\Models\studydepartament;

use App\Models\admin\SendTask;
use App\Models\User;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyDepartament extends Model
{
    use HasFactory;

     public function tasks()
    {
        return $this->belongsToMany(Task::class, 'tasks_has_departments');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'department_user');
    }


}
