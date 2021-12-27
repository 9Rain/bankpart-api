<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => [
                'required', 'email',
                Rule::unique('users')->where(function ($query) {
                    $query->where('id', '<>', $this->id);
                })
            ],
            'user_role_id' => ['required', 'integer', 'exists:user_roles,id'],
            'password' => ['string', 'min:8'],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['id'] = $this->route('user')->id;
        return $data;
    }
}
