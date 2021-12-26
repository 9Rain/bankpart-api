<?php

namespace App\Http\Requests\Staff\Partition;

use Illuminate\Foundation\Http\FormRequest;

class ShowDeletePartitionRequest extends FormRequest
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
            'partition_account_id' => ['same:account_id'],
            'account_id' => ['same:partition_account_id'],
            'account_user_id' => ['same:user_id'],
            'user_id' => ['same:account_user_id'],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['partition_account_id'] = $this->route('partition')->account_id;
        $data['account_id'] = $this->route('account')->id;
        $data['account_user_id'] = $this->route('account')->user_id;
        $data['user_id'] = $this->route('user')->id;
        return $data;
    }
}
