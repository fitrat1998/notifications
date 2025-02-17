<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHasFile  extends Model
{
    use HasFactory;

    public $table = "tasks_has_files";

    public function task()
    {
        return $this->belongsTo(SendTask::class, 'task_id', 'id');
    }


}
