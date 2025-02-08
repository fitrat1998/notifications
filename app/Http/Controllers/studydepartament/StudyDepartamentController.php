<?php

namespace App\Http\Controllers\studydepartament;

use App\Http\Controllers\Controller;
use App\Http\Requests\studydepartament\StoreStudyDepartamentRequest;
use App\Http\Requests\studydepartament\UpdateStudyDepartamentRequest;
use App\Models\studydepartament\Donetask;
use App\Models\studydepartament\StudyDepartament;

class StudyDepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 12345;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 999;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudyDepartamentRequest $request)
    {

        if($request->accept){
            $donetask = Donetask::find($request->task_id);

            $donetask->update([
                'step'      => 1,
                'status'    => 'accepted',
                'updated_at' => NOW()
            ]);

            return redirect()->back()->with('success','So`rov muvaffaqiyatli qabul qilindi');

        }
        elseif($request->report){
            $donetask = Donetask::find($request->task_id1);

            $donetask->update([
                'step'       => 1,
                'status'     => 'cancelled',
                'report'     => $request->report,
                'updated_at' => NOW()
            ]);

            return redirect()->back()->with('danger','So`rov rad etildi');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(StudyDepartament $studyDepartament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudyDepartament $studyDepartament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudyDepartamentRequest $request, StudyDepartament $studyDepartament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudyDepartament $studyDepartament)
    {
        //
    }
}
