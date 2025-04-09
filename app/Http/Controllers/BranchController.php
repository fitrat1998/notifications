<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();

        return view('admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.branches.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user()->id;

        $branch = Branch::create([
            'name' => $request->name,
            'user_id' => $user,
//            'department_id'   => 0,
        ]);

        return redirect()->route('branches.index')->with('success', 'Kafedra muvaffaqiyatli qo`shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $branch = Branch::find($id);

        return view('admin.branches.edit', compact('branch'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $branch = Branch::find($id);

        if ($branch) {
            $branch->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('branches.index')->with('success', 'Kafedra muvaffaqiyatli tahrirlandi');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $branch = Branch::find($id);

        if ($branch) {
            $branch->delete();
        }

        return redirect()->route('branches.index')->with('success', 'Kafedra muvaffaqiyatli o`chirildi');
    }
}
