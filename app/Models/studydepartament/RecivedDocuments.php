<?php

namespace App\Models\studydepartament;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class RecivedDocuments extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'user_id',
            'userdocs_id',
            'comment',
            'deadline',
            'status',
            'step',
            'report'
        ];




}
