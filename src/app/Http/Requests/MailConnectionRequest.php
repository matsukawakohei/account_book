<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailConnectionRequest extends FormRequest
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
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => trans('mail_connection.errors.email.required'),
            'email.string'      => trans('mail_connection.errors.email.string'),
            'email.email'       => trans('mail_connection.errors.email.email'),
            'password.required' => trans('mail_connection.errors.password.required'),
            'password.string'   => trans('mail_connection.errors.password.string'),
        ];
    }
}
