<?php

namespace App\Http\Controllers;

use App\Models\admin\Faculty;
use App\Models\Direction;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();

        $faculties = Faculty::all();

        return view('admin.groups.index', compact('groups', 'faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all();

        return view('admin.groups.add', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
//        dd($request);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'direction_id' => 'required',
        ]);

        $user = auth()->user()->id;

        $group = Group::create([
            'name' => $request->name,
            'user_id' => $user,
            'direction_id' => $request->direction_id,
        ]);

        return redirect()->route('groups.index')->with('success', 'Guruh muvaffaqiyatli qo`shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $faculty = Faculty::findOrFail($id);

        return response()->json($faculty);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $direction_old = Direction::find($group->direction_id);
        $faculty_old = Faculty::find($direction_old->faculty_id);
        $faculties = Faculty::all();
        $directions = Direction::all();

        return view('admin.groups.edit', compact('group', 'faculties', 'directions', 'faculty_old', 'direction_old'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'direction_id' => 'required',
        ]);

        $user = auth()->user()->id;

        $group = Group::find($id);

        if ($group) {
            $data = array_filter([
                'name' => $request->name,
                'user_id' => $user,
                'direction_id' => $request->direction_id,
            ], function ($value) {
                return $value !== null;
            });

            $group->update($data);
        }

        return redirect()->route('groups.index')->with('success', 'Guruh muvaffaqiyatli tahrirlandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        if ($group) {
            $group->delete();
        }

        return redirect()->route('groups.index')->with('success', 'Guruh muvaffaqiyatli o`chirildi');
    }
}
