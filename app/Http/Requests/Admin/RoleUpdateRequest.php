<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $unique = Rule::unique(Role::class);

        return [
            'name' => ['required', 'string', 'max:255', $unique],
            'guard_name' => ['required', 'string', 'max:255', $unique],
            'description' => ['nullable', 'string']
        ];
    }
}
