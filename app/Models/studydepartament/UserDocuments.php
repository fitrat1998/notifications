<?php

namespace App\Models\studydepartament;

use App\Models\admin\Department;
use App\Models\documenttype\DocumentType;
use App\Models\Release;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UserDocuments extends Model
{
    use HasFactory, softdeletes;

    protected $fillable = [
        'user_id',
        'documenttype_id',
        'comment',
        'deadline',
        'status',
        'cancelled_user',
        'report'
    ];

    public function documenttype()
    {
        return $this->hasOne(DocumentType::class, 'id', 'documenttype_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function departments($id)
    {
        $user = auth()->user();

        $ids = DB::table('confirm_departments_map')
            ->where('documenttype_id', $id)
            ->pluck('department_id');

        $d = DB::table('userdocs_has_departments')->whereIn('department_id', $ids)->get();

        $dp_ids = $d->pluck('department_id');

        $departmen_names = Department::whereIn('id', $dp_ids)->get();
        return ['departmen_names' => $departmen_names, 'ids' => $d];
    }

    public function step_docs($id)
    {
        $status = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $id)
            ->get();

        $info = UserDocuments::find($id);
        $author = $info ? User::find($info->cancelled_user) : null;

        $departmentIds = $status->pluck('department_id')->toArray();

        $departments = Department::whereIn('id', $departmentIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $departmentIds) . ')')
            ->get();


        return [$status, $departments, $author, $info];
    }


    public function stepper($id)
    {
        $user = auth()->user();

        $ids = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $id)
//            ->where('department_id', $user->department_id)
            ->get();

        $departments_id = $ids->pluck('department_id');

        $c = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $id)
            ->where('department_id', $user->department_id)
//                    ->where('status', 'waiting')
            ->first();

        $p = DB::table('userdocs_has_departments')
            ->where('id', $c->id - 1)
            ->where('userdocs_id', $id)
            ->get();

        $n = DB::table('userdocs_has_departments')
            ->where('id', $c->id + 1)
            ->where('userdocs_id', $id)
            ->get();


        $departments = Department::whereIn('id', $departments_id)->get();

        return $c;
    }


    public function files()
    {
        return $this->hasMany(UserDocsHasFile::class, 'userdocs_id', 'id');
    }

    public function checkdone($id)
    {
        $user = auth()->user();

        $done = DoneUserDocs::where('userdocs_id', $id)
            ->where('user_id', $user->id)
            ->first();


        $cancel = UserDocuments::where('id', $id)
            ->where('status', 'cancelled')
            ->first();


        if ($cancel) {
            return 'cancel';
        } elseif ($done) {
            return 'done';
        } else {
            return false;
        }


    }

    public function userdoc($id)
    {
        $ud = DocumentType::find($id);
        return $ud;
    }

    public function checkstatus($id)
    {
        $user = auth()->user();

        $userdocs = UserDocuments::find($id);

        $doctype = DB::table('confirm_departments_map')->where('documenttype_id', $userdocs->documenttype_id)->first();


        $departments = DB::table('userdocs_has_departments')
            ->distinct('department_id')
            ->where('userdocs_id', $userdocs->id)
            ->get();

        $departments_id = $departments->pluck('department_id');

//        return $departments;

        return ['order' => $doctype->order, 'departments_id' => $departments_id];
    }

    public function status($userdocs_id, $department_id)
    {
        $data = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdocs_id)
            ->where('department_id', $department_id)
//            ->where('user_id', 0)
            ->first();

        return $data;
    }


    public function pre($userdocs_id, $status_id)
    {
        $department_id = auth()->user()->department_id;

        $userdocs = DB::table('userdocs_has_departments')
            ->where('id', $status_id - 1)
            ->where('userdocs_id', $userdocs_id)
            ->first();

        if ($userdocs) {
            return $userdocs;
        }

    }

    public function show($id, $userdocs_id)
    {

        $c = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdocs_id)
            ->where('id', $id)->first();

        $p = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdocs_id)
            ->where('id', $c->id - 1)->first();
        $n = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdocs_id)
            ->where('id', $c->id + 1)->first();

        if ($c) {
            $userdoc = UserDocuments::find($c->userdocs_id);

            if ($userdoc) {
                $order = DB::table('confirm_departments_map')->where('documenttype_id', $userdoc->documenttype_id)->first();

                if ($order && $order->order == 'on') {
                    if ((empty($p) && ($c->status == 'waiting' || $c->status == 'accepted')) ||
                        ($p && $p->status == 'accepted' && ($c->status == 'waiting' || $c->status == 'accepted'))) {
                        return 1;
                    }
                } else {
                    return 1;
                }
            }
        }


    }

    public function datas_for_admin($id)
    {
        $datas = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $id)
            ->get();

        $department_ids = $datas->pluck('department_id');

        $departments = Department::whereIn('id', $department_ids)->get();

        if ($departments->isNotEmpty()) {
            return [
                'departments' => $departments,
                'datas' => $datas
            ];
        } else {
            return [
                'departments' => collect(),
                'datas' => collect()
            ];
        }
    }

    public function finish_doc($userdoc)
    {
        $user = auth()->user();

        $current = DB::table('userdocs_has_departments')
//            ->where('id', $id)
            ->where('userdocs_id', $userdoc)
            ->where('department_id', $user->department_id)
            ->first();

        $previous = $current ? DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdoc)
            ->where('id', $current->id - 1)
            ->first() : null;


        $next = $current ? DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdoc)
            ->where('id', $current->id + 1)
            ->first() : null;

        if ($previous && $current) {
            if ($previous->status == 'accepted' && $current->status == 'accepted' && empty($next)) {
                return 1;
            } else {
                return null;
            }
        }
//        elseif(empty($previous) && empty($next) && $current) {
//            if($current->status == 'accepted')
//            {
//                return 1;
//            }
//        }

    }


    public function final_step_status($id)
    {
        $user = auth()->user();


        if ($id) {

            $final = DB::table('final_step_files')->where('userdocs_id', $id)
                ->where('user_id', $user->id)
                ->first();
        }

        if (is_null($final)) {
            return 0;

        } else {
            return $final;
        }

    }


    public function get_released_order($id)
    {
        $download = Release::where('document_id', $id)->first();

        if (!$download) {
            return null;
        } else {
            return $download->document_id;

        }

    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function info_user($id)
    {
        $user = User::find($id);
        return $user;
    }


    public function exists_release($id)
    {
        $doc = DB::table('releases')
            ->where('document_id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($doc) {
            return true;
        } else {
            return null;
        }

    }

    public function pre_done_users($id)
    {

        $done = DoneUserDocs::where('userdocs_id', $id)->get();
        $done = DoneUserDocs::where('userdocs_id', $id)->pluck('user_id');

        return User::whereIn('id', $done)->get();
    }

    public function doneuserdocs($id)
    {
        return DoneUserDocs::where('userdocs_id', $id)
            ->get();
    }

    public function doneuserdocs_files($id)
    {

        return DB::table('done_user_docs_files')
            ->where('done_user_docs_id', $id)
            ->get();
    }


}
