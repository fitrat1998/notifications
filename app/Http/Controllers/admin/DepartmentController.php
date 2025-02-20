<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\admin\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departments.add');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {

        $user_id = auth()->user()->id;

        $category = Department::insert([
            'name' => $request->name,
            'user_id' => $user_id
        ]);

        if ($category) {
            return redirect()->route('departments.index')->with('success', 'Kategoriya mucaffaqiyatli qo`shildi');
        } else {
            return redirect()->back()->with('error', 'Kategoriya allaqachon mavjud');
        }

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
            $category = Department::find($id);

            return view('admin.departments.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, string $id)
    {

        $update = Department::find($id);
        $update->update([
            'name' => $request->name,
        ]);

        if ($update) {
            return redirect()->route('departments.index')->with('success', 'Kategoriya mucaffaqiyatli tahrirlandi');
        }
        else {
            return redirect()->back()->with('error', 'Kategoriya tahrirlashdi xatolik yuz berdi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Department::find($id)->delete();

        if ($delete) {
            return redirect()->route('departments.index')->with('success', 'Kategoriya mucaffaqiyatli o`chirildi');
        }
        else {
            return redirect()->back()->with('error', 'Kategoriya o`chirishda xatolik yuz berdi');
        }
    }
}
