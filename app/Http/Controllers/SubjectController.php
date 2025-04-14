<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\faculty\Faculty;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();

        $faculties = Faculty::all();

        return view('admin.subjects.index', compact('subjects', 'faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all();

        $semesters = Semester::all();

        return view('admin.subjects.add', compact('faculties', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'faculty_id' => 'required',
            'direction_id' => 'required',
            'group_id' => 'required',
            'semester_id' => 'required',
        ]);

        $user = auth()->user()->id;

        $group = Subject::create([
            'name' => $request->name,
            'user_id' => $user,
            'direction_id' => $request->direction_id,
            'group_id' => $request->direction_id,
            'semester_id' => $request->direction_id,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Fan muvaffaqiyatli qo`shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $groups = Group::where('direction_id', $id)->get();

        return response()->json($groups);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subject = Subject::find($id);
        $groups = Group::all();
        $direction_old = Direction::find($subject->direction_id);
        $faculties = Faculty::all();
        $directions = Direction::all();
        $semesters = Semester::all();

        return view('admin.subjects.edit', compact('groups', 'faculties', 'directions', 'direction_old', 'subject', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'faculty_id' => 'required',
            'direction_id' => 'required',
            'group_id' => 'required',
            'semester_id' => 'required',
        ]);

        $user = auth()->user()->id;

        $subject = Subject::find($id);

        if ($subject) {
            $data = array_filter([
                'name' => $request->name,
                'user_id' => $user,
                'direction_id' => $request->direction_id,
                'group_id' => $request->group_id,
                'semester_id' => $request->semester_id,
            ], function ($value) {
                return $value !== null;
            });

            $subject->update($data);
        }


        return redirect()->route('subjects.index')->with('success', 'Fan muvaffaqiyatli tahrirlandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);

        if ($subject) {
            $subject->delete();
        }

        return redirect()->route('subjects.index')->with('success', 'Fan muvaffaqiyatli o`chirildi');
    }
}
