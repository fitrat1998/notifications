<?php

namespace App\Http\Requests\faculty;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonetaskRequest extends FormRequest
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
            'task_id' => 'required|exists:send_tasks,id',
            'comment' => 'required|string',
            'files.*' => 'nullable|file|max:2048|mimes:jpeg,png,pdf,doc,docx,xlsx',
            'status',
            'step',
            'report',
        ];
    }
}
