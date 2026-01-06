<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('user_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->route('user')->id,
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
            'profile_image' => 'nullable|array',
            'profile_image.*' => 'nullable|string',
        ];
        if (! empty($this->request->get('password'))) {
            $rules['password'] = ['required', 'min:8'];
        }

        return $rules;
    }
}
