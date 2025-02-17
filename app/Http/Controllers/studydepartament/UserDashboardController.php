<?php

namespace App\Http\Controllers\studydepartament;

use App\Http\Controllers\Controller;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\UserDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function accepted_docs()
    {
        $user = auth()->user();

        $userdocs = UserDocuments::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->pluck('id');


        $departments = DB::table('userdocs_has_departments')
            ->select('userdocs_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'accepted')
            ->whereIn('userdocs_id', $userdocs)
            ->groupBy('userdocs_id')
            ->get();

        $created_docs_id = $departments->pluck('userdocs_id');

        $accepted_docs = UserDocuments::where('user_id', $user->id)
            ->whereIn('id', $created_docs_id)
            ->where('status', '!=', 'cancelled')
            ->get();

//        dd($accepted_docs);

        return view('studydepartments.documents.accepted_docs', compact('accepted_docs'));

    }

    public function waiting_docs()
    {
        $user = auth()->user();

        $departments = DB::table('userdocs_has_departments')
            ->select('userdocs_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'waiting')
            ->groupBy('userdocs_id')
            ->pluck('userdocs_id');

        $waiting_docs = UserDocuments::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->whereIn('id', $departments)
            ->get();

        return view('studydepartments.documents.waiting_docs', compact('waiting_docs'));


    }

    public function cancelled_docs()
    {
        $user = auth()->user();

        $cancelled_docs = UserDocuments::where('user_id', $user->id)
            ->where('cancelled_user', '!=', $user->id)
            ->where('status', '=', 'cancelled')
            ->where('cancelled_user', '>', 0)
            ->get();

//        dd($cancelled_docs);

        return view('studydepartments.documents.cancelled_docs', compact('cancelled_docs'));

    }

    public function my_accepted_docs()
    {
        $user = auth()->user();

        $anotherdocs = UserDocuments::where('user_id', '!=', $user->id)->pluck('id');

        $my_accepted_docs_id = DB::table('userdocs_has_departments')
            ->where('department_id', $user->department_id)
//            ->whereIn('userdocs_id', $anotherdocs)
            ->where('status', 'accepted')
            ->pluck('userdocs_id');

        $my_accepted_docs = DoneUserDocs::whereIn('userdocs_id', $my_accepted_docs_id)
            ->where('user_id', $user->id)
            ->get();

        $cancelled_my_docs = UserDocuments::where('cancelled_user', $user->id)
            ->where('status', 'cancelled')
            ->count();

        return view('studydepartments.documents.my_accepted_docs', compact('my_accepted_docs'));

    }

    public function my_waiting_docs()
    {
        $user = auth()->user();

        $recived_docs_docs_id = DB::table('userdocs_has_departments')
            ->where('department_id', $user->department_id)
            ->where('status', 'waiting')
            ->pluck('userdocs_id');

        $my_waiting_docs = UserDocuments::whereIn('id', $recived_docs_docs_id)->get();

//        dd($my_waiting_docs);

        return view('studydepartments.documents.my_waiting_docs', compact('my_waiting_docs'));
    }

    public function my_cancelled_docs()
    {
        $user = auth()->user();


        $my_cancelled_docs = UserDocuments::where('cancelled_user', $user->id)
            ->where('status', 'cancelled')
            ->get();


        return view('studydepartments.documents.my_cancelled_docs', compact('my_cancelled_docs'));
    }

    public function doc_done_list($ids)
    {

        $user = auth()->user();

        $userdocs = UserDocuments::where('id', $ids)
            ->where('status', '!=', 'cancelled')
            ->pluck('id');




        $departments = DB::table('userdocs_has_departments')
            ->select('userdocs_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'accepted')
            ->whereIn('userdocs_id', $userdocs)
            ->groupBy('userdocs_id')
            ->get();



        $created_docs_id = $departments->pluck('userdocs_id');


        $my_accepted_docs_list = DoneUserDocs::whereIn('userdocs_id', $created_docs_id)->get();


        return view('studydepartments.documents.my_accepted_docs_list', compact('my_accepted_docs_list'));
    }


    public function my_accepted_tasks()
    {
        return 1;
    }

    public function my_waiting_tasks()
    {
        return 2;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ('Coming soon');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
