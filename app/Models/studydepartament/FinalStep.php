<?php

namespace App\Models\studydepartament;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'file',
        'name',
        'userdocs_id',
        'doctype_id',
        'comment',
    ];
}
