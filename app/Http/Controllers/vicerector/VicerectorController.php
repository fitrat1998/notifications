<?php

namespace App\Http\Controllers\vicerector;

use App\Http\Controllers\Controller;
use App\Http\Requests\vicerector\StoreVicerectorRequest;
use App\Http\Requests\vicerector\UpdateVicerectorRequest;
use App\Models\studydepartament\Donetask;
use App\Models\vicerector\Vicerector;

class VicerectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreVicerectorRequest $request)
    {
         if ($request->accept) {
            $donetask = Donetask::find($request->task_id);

            $donetask->update([
                'step' => 3,
//                'status' => 'accepted',
                'updated_at' => NOW()
            ]);

            return redirect()->back()->with('success', 'So`rov muvaffaqiyatli qabul qilindi');

        }
        elseif ($request->report) {
            $donetask = Donetask::find($request->task_id1);

            $donetask->update([
                'step' => 2,
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
    public function show(Vicerector $vicerector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vicerector $vicerector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVicerectorRequest $request, Vicerector $vicerector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vicerector $vicerector)
    {
        //
    }
}
