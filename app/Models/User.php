<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\admin\Department;
use App\Models\admin\Faculty;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\UserDocsHasDoneFile;
use App\Models\studydepartament\UserDocuments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'position',
        'login',
        'email',
        'department_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function faculty($id)
    {
        $faculty = Faculty::find($id);

        return $faculty->name ?? "Mavjud emas";
    }

    public function department()
    {

        return $this->belongsTo(Department::class)->withDefault();

    }

    public function userdocuments()
    {
        return $this->belongsTo(UserDocuments::class, 'document_id', 'id');
    }

    public function doneuserdocs()
    {
        return $this->hasMany(DoneUserDocs::class, 'user_id', 'id')
            ->orWhere('userdocs_id', $this->id);
    }

    public function done_user_docs_files($id)
    {
        $files = UserDocsHasDoneFile::where('done_user_docs_id', $id)->get();

        if ($files) {
            return $files;
        } else {
            return null;
        }
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

}
