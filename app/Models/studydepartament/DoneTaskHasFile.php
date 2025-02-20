<?php

namespace App\Models\studydepartament;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoneTaskHasFile extends Model
{
    use HasFactory;

    public $table = "done_tasks_has_files";

    public function doneuserdocs()
    {
        return $this->belongsTo(DoneUserDocs::class, 'id');
    }

}
