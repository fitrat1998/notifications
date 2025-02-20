<?php

namespace App\Models\admin;

use App\Models\documenttype\DocumentType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function sendtask()
{
    return $this->hasMany(SendTask::class, 'task_id', 'id');
}

    public function user()
    {
        return $this->hasOne(User::class)->withDefault();
    }

    public function documents()
    {
        return $this->belongsToMany(DocumentType::class, 'documenttypes_has_deparments', 'department_id', 'documenttype_id');
    }

}
