<?php

namespace App\Models\studydepartament;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocsHasDoneFile  extends Model
{
    use HasFactory;

    public $table = "done_user_docs_files";

    protected $fillable = [
        'userdocs_id',
        'done_user_docs_files',
        'name',
        'status',
    ];

     public function doneuserdocs()
    {
        return $this->belongsTo(DoneUserDocs::class, 'id');
    }


}
