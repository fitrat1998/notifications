<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semestrs = Semester::all();

        return view('admin.semesters.index', compact('semestrs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.semesters.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSemesterRequest $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user()->id;

        $semester = Semester::create([
            'name' => $request->name,
            'user_id' => $user,
//            'department_id'   => 0,
        ]);

        return redirect()->route('semesters.index')->with('success', 'Kafedra muvaffaqiyatli qo`shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $semester = Semester::find($id);

        return view('admin.semesters.edit', compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSemesterRequest $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $semester = Semester::find($id);

        if ($semester) {
            $semester->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('semesters.index')->with('success', 'Kafedra muvaffaqiyatli tahrirlandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $semester = Semester::find($id);

        if ($semester) {
            $semester->delete();
        }

        return redirect()->route('semesters.index')->with('success', 'Kafedra muvaffaqiyatli o`chirildi');
    }
}
