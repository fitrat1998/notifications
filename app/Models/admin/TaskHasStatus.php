<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHasDepartment  extends Model
{
    use HasFactory;

    public $table = "tasks_has_departments";


}
