<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public static function check(int $task_id, int $id): bool
    {
        $faculty = DB::table('tasks_has_faculties')
            ->where('task_id', $task_id)
            ->where('faculty_id', $id)
            ->exists();

        return $faculty !== false;
    }



    public function user()
    {
        return $this->hasMany(User::class, 'faculty_id');
    }

}
