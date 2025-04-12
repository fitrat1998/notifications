<?php

namespace App\Http\Controllers;

use App\Models\admin\Faculty;
use App\Models\Direction;
use App\Http\Requests\StoreDirectionRequest;
use App\Http\Requests\UpdateDirectionRequest;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $directions = Direction::all();

        return view('admin.directions.index', compact('directions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('admin.directions.add', compact('faculties'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDirectionRequest $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'faculty_id' => 'required',
        ]);


        $user = auth()->user()->id;

        $branch = Direction::create([
            'name' => $request->name,
            'user_id' => $user,
            'faculty_id' => $request->faculty_id,
        ]);

        return redirect()->route('directions.index')->with('success', 'Yo`nalish muvaffaqiyatli qo`shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Direction $direction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $direction = Direction::find($id);

        $faculties = Faculty::all();

        return view('admin.directions.edit', compact('direction', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDirectionRequest $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'faculty_id' => 'required',
        ]);

        $direction = Direction::find($id);

        if ($direction) {
            $direction->update([
                'name' => $request->name,
                'faculty_id' => $request->faculty_id,
            ]);
        }

        return redirect()->route('directions.index')->with('success', 'Bo`lim muvaffaqiyatli tahrirlandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $direction = Direction::find($id);

        if ($direction) {
            $direction->delete();
        }

        return redirect()->route('directions.index')->with('success', 'Yo`nalish muvaffaqiyatli o`chirildi');
    }
}
