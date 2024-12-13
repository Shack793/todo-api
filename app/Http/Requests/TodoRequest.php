<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:completed,in-progress,not-started',
        ];

        if ($this->isMethod('PUT')) {
            $rules = [
                'title' => 'sometimes|required|string|max:255',
                'details' => 'nullable|string',
                'status' => 'sometimes|required|in:completed,in-progress,not-started',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The todo title is required.',
            'title.max' => 'The todo title cannot be longer than 255 characters.',
            'status.required' => 'The todo status is required.',
            'status.in' => 'The status must be one of: completed, in-progress, not-started.',
        ];
    }
}
