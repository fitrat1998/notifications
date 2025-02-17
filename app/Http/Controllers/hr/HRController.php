<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\hr\StoreHRRequest;
use App\Http\Requests\hr\UpdateHRRequest;
use App\Models\hr\HR;
use App\Models\studydepartament\Donetask;

class HRController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hrs.index');
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
    public function store(StoreHRRequest $request)
    {
        if ($request->accept) {
            $donetask = Donetask::find($request->task_id);

            $donetask->update([
                'step' => 4,
                'updated_at' => NOW()
            ]);

            return redirect()->back()->with('success', 'So`rov muvaffaqiyatli qabul qilindi');

        } elseif ($request->report) {

            $donetask = Donetask::find($request->task_id1);

            if ($request->department) {

                $donetask->update([
                    'step' => 0,
                    'status' => 'cancelled',
                    'report' => $request->report,
                    'updated_at' => NOW()
                ]);
            }
            elseif ($request->lawyer) {
                $donetask->update([
                    'step' => 1,
                    'status' => 'cancelled',
                    'report' => $request->report,
                    'updated_at' => NOW()
                ]);
            }
            elseif ($request->vicerector) {
                $donetask->update([
                    'step' => 2,
                    'status' => 'cancelled',
                    'report' => $request->report,
                    'updated_at' => NOW()
                ]);
            }
            else {
                $donetask->update([
                    'step' => 3,
                    'status' => 'cancelled',
                    'report' => $request->report,
                    'updated_at' => NOW()
                ]);
            }

            return redirect()->back()->with('danger', 'So`rov rad etildi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HR $hR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HR $hR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHRRequest $request, HR $hR)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HR $hR)
    {
        //
    }
}
