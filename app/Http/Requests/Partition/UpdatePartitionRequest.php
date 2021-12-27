<?php

namespace App\Http\Requests\Partition;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartitionRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['nullable', 'min:3', 'max:9999'],
            'due_date' => ['nullable', 'date'],
            'balance' => ['required', 'numeric', 'min:0'],
            'goal' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
