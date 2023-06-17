<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManualAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:50',
            'amount'         => 'required|integer|min:1',
            'account_date'   => 'required|date'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'            => trans('account.errors.name.required'),
            'name.string'              => trans('account.errors.name.string'),
            'name.max'                 => trans('account.errors.name.max'),
            'amount.required'          => trans('account.errors.amount.required'),
            'amount.integer'           => trans('account.errors.amount.integer'),
            'amount.min'               => trans('account.errors.amount.min'),
            'account_date.required'    => trans('account.errors.date.required'),
            'account_date.min'         => trans('account.errors.date.date')
        ];
    }
}
