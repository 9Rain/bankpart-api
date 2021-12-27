<?php

namespace App\Http\Requests\Partition;

use Illuminate\Foundation\Http\FormRequest;

class OutcomePartitionRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'min:0.01', 'lte:balance'],
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['balance'] = $this->route('partition')->balance;
        return $data;
    }
}
