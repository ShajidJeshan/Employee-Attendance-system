<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormValidation extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|unique:users|email',
            'gender' => 'required',//
            'employee_id' => 'required',
            // 'mobile_number' => 'required|preg_match(^(?:\+88|01)?\d{11}\r?$)',
            // 'mobile_number' => 'required|regex:^(?:\+88|01)?\d{11}\r?$',
            'mobile_number' => 'required','regex:/[0-9]([0-9]|-(?!-))?+/',
            'password' => 'required',
            'confirm_password' => 'required',
            'join_date' => 'required',
            'designation' => 'required',//
            'department' => 'required',//
            'role' => 'required',
            'leave_policy' => 'required',//
            'employment_type' => 'required',//
            'shift_group' => 'required',//
            'workplace' => 'required'//
        ];
    }
}
