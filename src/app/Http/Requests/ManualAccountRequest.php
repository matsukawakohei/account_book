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
            'name'           => 'string|max:50',
            'amount'         => 'integer|min:1',
            'account_date'   => 'date'
        ];
    }

    public function messages(): array
    {
        return [
            'name.string'              => trans('account.errors.name.string'),
            'name.max'                 => trans('account.errors.name.max'),
            'amount.integer'           => trans('account.errors.amount.integer'),
            'amount.min'               => trans('account.errors.amount.min'),
            'account_date.date'        => trans('account.errors.date.date'),
        ];
    }
}
