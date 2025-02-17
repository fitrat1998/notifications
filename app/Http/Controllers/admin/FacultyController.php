<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\admin\Faculty;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::all();
        return view('admin.faculties.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faculties.add');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacultyRequest $request)
    {
        $user_id = auth()->user()->id;
        $create = Faculty::insert([
            'name' => $request->name,
            'user_id' => $user_id,
        ]);

        if ($create) {
            return redirect()->route('faculty.index')->with('success', 'Fakultet  muvaffaqiyatli qo`shildi');
        }
        else {
            return redirect()->back()->with('error', 'Fakultet qo`shishda xatolik yuz berdi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $faculty = Faculty::find($id);
        return view('admin.faculties.edit',compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacultyRequest $request, $id)
    {
        $update = Faculty::find($id);
        $update->update([
            'name' => $request->name,
        ]);

         if ($update) {
            return redirect()->route('faculty.index')->with('success', 'Fakultet  muvaffaqiyatli tahrirlandi');
        }
        else {
            return redirect()->back()->with('error', 'Fakultet tahrirlashdi xatolik yuz berdi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = Faculty::find($id)->delete();

         if ($delete) {
            return redirect()->route('faculty.index')->with('success', 'Fakultet  muvaffaqiyatli o`chirildi');
        }
        else {
            return redirect()->back()->with('error', 'Fakultet o`chirishda xatolik yuz berdi');
        }
    }
}
