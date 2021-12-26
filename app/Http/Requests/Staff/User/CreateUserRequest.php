<?php

namespace App\Http\Requests\Staff\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:191'],
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'user_role_id' => ['required', 'integer', 'exists:user_roles,id'],
            'password' => ['string', 'min:8'],
        ];
    }
}
