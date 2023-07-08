<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailConnectionUpdateRequest extends FormRequest
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
            'email'    => ['required', 'string', 'email'],
            'password' => ['nullable', 'string'],
            'mail_box' => ['string', 'regex:/^[a-zA-Z]+$/', 'nullable'],
            'subject'  => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => trans('mail_connection.errors.email.required'),
            'email.string'      => trans('mail_connection.errors.email.string'),
            'email.email'       => trans('mail_connection.errors.email.email'),
            'password.string'   => trans('mail_connection.errors.password.string'),
            'mail_box.string'   => trans('mail_connection.errors.mail_box.string'),
            'mail_box.regex'    => trans('mail_connection.errors.mail_box.regex'),
            'subject.required'  => trans('mail_connection.errors.subject.required'),
            'subject.string'    => trans('mail_connection.errors.subject.string')
        ];
    }
}
