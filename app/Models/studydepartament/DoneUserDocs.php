<?php

namespace App\Models\studydepartament;

use App\Models\admin\Department;
use App\Models\documenttype\DocumentType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DoneUserDocs extends Model
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

    public function userdocs($id)
    {

        $userdocs = UserDocuments::find($id);

        if ($userdocs) {
            $document = DocumentType::find($userdocs->documenttype_id);
        } else {
            $document = null;
        }


        return ['document' => $document, 'old' => $userdocs];
    }

    public function files()
    {
        return $this->hasMany(UserDocsHasDoneFile::class, 'done_user_docs_id', 'id');
    }

    public function documenttype($id)
    {
        $donetdocs = DoneUserDocs::find($id);

        $userdocs = UserDocuments::find($donetdocs->userdocs_id);

        $doctype = DocumentType::find($userdocs->documenttype_id);


        return $doctype;
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


        if ($doctype->order == 'on') {


            $departments = DB::table('userdocs_has_departments')
                ->where('userdocs_id', $userdocs->id)
                ->get();


            foreach ($departments as $d) {
                if ($d->department_id == $user->department_id) {
                    $p = DB::table('userdocs_has_departments')
                        ->where('userdocs_id', $userdocs->id)
                        ->where('department_id', $d->department_id - 1)
                        ->first();

                    $n = DB::table('userdocs_has_departments')
                        ->where('userdocs_id', $userdocs->id)
                        ->where('department_id', $d->department_id + 1)
                        ->first();

                    $c = DB::table('userdocs_has_departments')
                        ->where('userdocs_id', $userdocs->id)
                        ->where('department_id', $d->department_id)
                        ->first();

                    if ($p && $n) {
                        if ($p->status == 'accepted' && $c->status == 'waiting') {
                            return 1;
                        }
                    } elseif (!$p && $n) {
                        if ($c->status == 'waiting') {
                            return 2;
                        }
                    } elseif ($p && !$n) {
                        if ($p->status == 'accepted' && $c->status == 'waiting') {
                            return 3;
                        }
                    }
                }
            }
            return false;
        } else {
            return true;
        }

    }

    public function status($userdocs_id, $department_id)
    {
        $data = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $userdocs_id)
            ->where('department_id', $department_id)
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

    public function show($id)
    {

        $p = DB::table('userdocs_has_departments')->where('id', $id - 1)->first();
        $c = DB::table('userdocs_has_departments')->where('id', $id)->first();
        $n = DB::table('userdocs_has_departments')->where('id', $id + 1)->first();

        if ($c) {
            $userdoc = UserDocuments::find($c->userdocs_id);

            if ($userdoc) {
                $order = DB::table('confirm_departments_map')->where('documenttype_id', $userdoc->documenttype_id)->first();

                if ($order && $order->order == 'on') {
                    if ((empty($p) || $p->status == 'accepted') && ($c->status == 'waiting' || $c->status == 'accepted') && (empty($n) || $n->status == 'waiting')) {
                        return 1;
                    } elseif ($c->status == 'accepted' || $c->status == 'waiting' && (empty($p) || $p->status == 'accepted')) {
                        return 2;
                    }
                } else {
                    return 3;
                }
            }
        }


    }


    public function done_departments($id)
    {
        $user = auth()->user();

        $userdoc = UserDocuments::find($id);

        $ids = DB::table('confirm_departments_map')
            ->where('documenttype_id', $userdoc->documenttype_id)
            ->pluck('department_id');

        $d = DB::table('userdocs_has_departments')->whereIn('department_id', $ids)->get();

        $dp_ids = $d->pluck('department_id');

        $departmen_names = Department::whereIn('id', $dp_ids)->get();

        $dp_ids = $ids->toArray();

        return [$departmen_names, $dp_ids];
    }

    public function done_department_single($id)
    {
        $user = auth()->user();

        $userdoc = UserDocuments::find($id);

        $doneuserdoc = DoneUserDocs::find($id);

        $userDepartmentId = User::find($doneuserdoc->user_id);

        $departmen_names = Department::where('id', $userDepartmentId->department_id)->first();


        return $departmen_names->name;
    }

    public function userdoc_status($id)
    {
        $doc = DoneUserDocs::find($id);

        $status = DB::table('userdocs_has_departments')
            ->where('userdocs_id', $doc->userdocs_id)
            ->where('updated_at', $doc->created_at)
            ->first();

        return $status;
    }



}
