<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserEditRequest extends Request
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
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            // 'username' => 'required|max:100|unique:users',
            // 'password' => 'required|min:6|confirmed',
            'role' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [];
    }
}


