<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSendTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'        => 'required|string',
            'comment'      => 'required',
            'deadline'     => '',
            'files.*'      => 'required|file|mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx',
            'read',
            'status'
        ];
    }
}
