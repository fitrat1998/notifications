<?php

namespace App\Http\Controllers\studydepartament;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFinalStepRequest;
use App\Http\Requests\UpdateFinalStepRequest;
use App\Models\studydepartament\FinalStep;
use App\Models\studydepartament\UserDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FinalStepController extends Controller
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
    public function store(Request $request)
    {
//        dd($request);

        $id = $request->userdoc_id;
        $user = auth()->user()->id;

        $request->validate([
            'comment' => 'required|string|max:255',
            'department_id' => '',
            'files.*' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        $userdocs = UserDocuments::findOrFail($id);

        $doctype_id = $request->input('doctype_id');


        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $hashedName = $file->hashName();

                $filePath = public_path('storage/final_steps/' . $hashedName);
                $file->move(public_path('storage/final_steps/'), $hashedName);

                $existingFile = DB::table('final_step_files')
                    ->where('user_id', auth()->user()->id)
                    ->where('department_id', $request->department_id)
                    ->where('userdocs_id', $userdocs->id)
                    ->where('doctype_id', $doctype_id)
                    ->where('name', $file->getClientOriginalName())
                    ->first();

                if (!$existingFile) {
                    DB::table('final_step_files')->insert([
                        'user_id' => auth()->user()->id,
                        'department_id' => $request->department_id,
                        'name' => $file->getClientOriginalName(),
                        'file' => $hashedName,
                        'userdocs_id' => $userdocs->id,
                        'doctype_id' => $doctype_id,
                        'comment' => $request->comment,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    return redirect()->route('reciveddocuments.index')->with('success', 'Ilova muvaffaqiyatli yuklandi!');

                }
            }
        } else {
            $exists = DB::table('final_step_files')
                ->where('user_id', auth()->user()->id)
                ->where('department_id', $request->department_id)
                ->where('userdocs_id', $userdocs->id)
                ->where('doctype_id', $doctype_id)
                ->exists();

            if (!$exists) {
                DB::table('final_step_files')->insert([
                    'user_id' => auth()->user()->id,
                    'department_id' => $request->department_id,
                    'name' => 'empty',
                    'file' => 'empty',
                    'userdocs_id' => $userdocs->id,
                    'doctype_id' => $doctype_id,
                    'comment' => $request->comment,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return redirect()->route('reciveddocuments.index')->with('success', 'Ilova muvaffaqiyatli yuklandi!');

            }
        }

        return redirect()->route('reciveddocuments.index')->with('danger', 'Bu malumotlar avval kiritilgan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $user = auth()->user();

        $final = DB::table('final_step_files')->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($final) {
            $userdocs = UserDocuments::find($final->userdocs_id);
        }


        return view('studydepartments.reciveddocuments.list_final_step', compact('userdocs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinalStep $finalStep)
    {
        //
    }


    public function download($filename)
    {
        $filePath = public_path('storage/final_steps/' . $filename);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return abort(404, 'File not found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinalStepRequest $request, FinalStep $finalStep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $final = DB::table('final_step_files')->where('id', $id)
            ->delete();

        if ($final) {
            return redirect()->route('reciveddocuments.index')->with('success', 'Ilova muvvafaqiyatli o`chirildi');
        } else {
            return redirect()->route('reciveddocuments.index')->with('danger', 'Ilova  o`chirishda xatolik yuz berdi');

        }

    }
}
