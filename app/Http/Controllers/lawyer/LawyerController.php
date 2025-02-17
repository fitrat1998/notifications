<?php

namespace App\Http\Controllers\lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\lawyer\StoreLawyerRequest;
use App\Http\Requests\lawyer\UpdateLawyerRequest;
use App\Models\lawyer\Lawyer;
use App\Models\studydepartament\Donetask;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lawyers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLawyerRequest $request)
    {
        if ($request->accept) {
            $donetask = Donetask::find($request->task_id);

            $donetask->update([
                'step' => 2,
//                'status' => 'accepted',
                'updated_at' => NOW()
            ]);

            return redirect()->back()->with('success', 'So`rov muvaffaqiyatli qabul qilindi');

        }
        elseif ($request->report) {
            $donetask = Donetask::find($request->task_id1);

            $donetask->update([
                'step' => 1,
                'status' => 'cancelled',
                'report' => $request->report,
                'updated_at' => NOW()
            ]);

            return redirect()->back()->with('danger', 'So`rov rad etildi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lawyer $lawyer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lawyer $lawyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLawyerRequest $request, Lawyer $lawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        //
    }
}
