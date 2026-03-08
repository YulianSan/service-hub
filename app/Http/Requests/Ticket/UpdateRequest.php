<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'attachment' => ['nullable', 'file', 'max:40000', 'mimes:txt,json']
        ];
    }
}
