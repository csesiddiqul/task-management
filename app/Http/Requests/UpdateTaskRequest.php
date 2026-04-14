<?php

namespace App\Http\Requests;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    use FailedValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:pending,in_progress,review,completed',
            'priority' => 'sometimes|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}
