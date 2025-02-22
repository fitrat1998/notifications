<?php

namespace App\Http\Controllers\documenttype;

use App\Http\Controllers\Controller;
use App\Http\Requests\documenttype\StoreDocumentTypeRequest;
use App\Http\Requests\documenttype\UpdateDocumentTypeRequest;
use App\Models\admin\Department;
use App\Models\documenttype\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documenttypes = DocumentType::all();
        return view('documenttypes.index', compact('documenttypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('documenttypes.add', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentTypeRequest $request)
    {
        $validated = $request->validated();

//        dd($request);

        $user = auth()->user();

        $create = DocumentType::create([
            'user_id' => $user->id,
            'name' => $validated['name'],

        ]);

        foreach ($request->department_id as $d) {
            DB::table('documenttypes_has_deparments')->insert([
                'documenttype_id' => $create->id,
                'department_id' => intval($d),
                'order' => 'off',
            ]);
        }

        return redirect()->route('documenttypes.index')->with('success', 'Hujjat turi muvaffaqiyatli yaratildi');

    }

    public function mapedit($id)
    {

        $documenttype = DocumentType::findOrFail($id);


        $departments = Department::all();

        $depart_id = DB::table('confirm_departments_map')->where('documenttype_id', $documenttype->id)->pluck('department_id')->toArray();

        $check = DB::table('confirm_departments_map')->where('documenttype_id', $documenttype->id)->first();

        if ($check) {
            if ($check->order == 'on') {
                $check = 'on';
            } else {
                $check = 'off';
            }
        }


        return view('documenttypes.map', compact('documenttype', 'departments', 'depart_id', 'check'));
    }

    public function mapupdate(Request $request, $id)
    {
        $documenttype = DocumentType::findOrFail($id);


//        dd($request);


        $depart_id = DB::table('confirm_departments_map')->where('documenttype_id', $documenttype->id)->delete();

        if ($request->order) {
            if ($request->department_id) {
                foreach ($request->department_id as $d) {
                    DB::table('confirm_departments_map')->insert([
                        'documenttype_id' => $documenttype->id,
                        'department_id' => intval($d),
                        'order' => 'on',
                    ]);

                }
            }
        } else {
            if ($request->department_id) {
                foreach ($request->department_id as $d) {
                    DB::table('confirm_departments_map')->insert([
                        'documenttype_id' => $documenttype->id,
                        'department_id' => intval($d),
                        'order' => 'off',
                    ]);

                }
            }
        }

        if ($documenttype) {
            return redirect()->route('documenttypes.index')->with('success', 'Xarita muvaffaqiyatli yangilandi');

        } else {
            return redirect()->back()->with('error', 'Xarita tahrirlashda    xatolik yuz berdi');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(DocumentType $documentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $departments = Department::all();
        $documenttype = DocumentType::find($id);
        $depart_id = DB::table('documenttypes_has_deparments')->where('documenttype_id', $documenttype->id)->pluck('department_id')->toArray();

        return view('documenttypes.edit', compact('departments', 'documenttype', 'depart_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentTypeRequest $request, $id)
    {
        $validated = $request->validated();

//        dd($request);

        $documenttype = DocumentType::find($id);


        $documenttype->update([
            'name' => $validated['name'],
        ]);

        $depart_id = DB::table('documenttypes_has_deparments')->where('documenttype_id', $documenttype->id)->delete();

        foreach ($request->department_id as $d) {
            DB::table('documenttypes_has_deparments')->insert([
                'documenttype_id' => $documenttype->id,
                'department_id' => intval($d),
                'order' => 'off'
            ]);
        }

        if ($documenttype) {
            return redirect()->route('documenttypes.index')->with('success', 'Hujjat turi muvaffaqiyatli yangilandi');

        } else {
            return redirect()->back()->with('error', 'Hujjat turi tahrirlashdi xatolik yuz berdi');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $documenttype = DocumentType::find($id);
        $depart_id = DB::table('documenttypes_has_deparments')->where('documenttype_id', $documenttype->id)->delete();
        DocumentType::find($id)->delete();

        return redirect()->route('documenttypes.index')->with('success', 'Hujjat turi muvaffaqiyatli o`chirildi');
    }
}
