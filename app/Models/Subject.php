<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name', 'user_id','direction_id','group_id','semester_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
