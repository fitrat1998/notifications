<?php

namespace App\Http\Controllers;

use App\Models\SendNote;
use App\Http\Requests\StoreSendNoteRequest;
use App\Http\Requests\UpdateSendNoteRequest;

class SendNoteController extends Controller
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
    public function store(StoreSendNoteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SendNote $sendNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SendNote $sendNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSendNoteRequest $request, SendNote $sendNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendNote $sendNote)
    {
        //
    }
}
