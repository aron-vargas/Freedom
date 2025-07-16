<?php

namespace App\Http\Requests\Admin;

use App\Models\Permission;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $unique = Rule::unique(Permission::class);

        return [
            'name' => ['required', 'string', 'max:255', $unique],
            'guard_name' => ['required', 'string', 'max:255', $unique],
            'description' => ['nullable', 'string']
        ];
    }
}
