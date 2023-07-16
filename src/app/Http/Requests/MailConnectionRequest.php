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
            'email'    => ['email'],
            'password' => ['string'],
            'mail_box' => ['string', 'regex:/^[a-zA-Z]+$/', 'nullable'],
            'subject'  => ['string']
        ];
    }

    public function messages(): array
    {
        return [
            'email.email'       => trans('mail_connection.errors.email.email'),
            'password.string'   => trans('mail_connection.errors.password.string'),
            'mail_box.string'   => trans('mail_connection.errors.mail_box.string'),
            'mail_box.regex'    => trans('mail_connection.errors.mail_box.regex'),
            'subject.string'    => trans('mail_connection.errors.subject.string'),
        ];
    }
}
