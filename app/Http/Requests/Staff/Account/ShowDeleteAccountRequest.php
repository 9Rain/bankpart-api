<?php

namespace App\Http\Requests\Staff\Account;

use Illuminate\Foundation\Http\FormRequest;

class ShowDeleteAccountRequest extends FormRequest
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
            'user_id' => ['same:account_user_id'],
            'account_user_id' => ['same:user_id'],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['account_user_id'] = $this->route('account')->user_id;
        $data['user_id'] = $this->route('user')->id;
        return $data;
    }
}
