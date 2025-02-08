<?php

namespace App\Models\documenttype;

use App\Models\admin\Department;
use App\Models\studydepartament\UserDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'documenttypes';

    protected $fillable = ['user_id', 'name'];

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'documenttypes_has_deparments', 'documenttype_id', 'department_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'tasks_has_departments', 'document_type_id', 'task_id');
    }

    public function userdocuments()
    {
        return $this->hasOne(UserDocuments::class, 'documenttype_id', 'id');
    }
}
