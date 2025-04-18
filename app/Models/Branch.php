<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','user_id','department_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
