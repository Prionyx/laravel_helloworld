<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->user->id;
        return $rules = [
            'name' => 'bail|required|max:255|unique:users,name,' . $id,
            'email' => 'bail|required|email|max:255|unique:users,email,' . $id
        ];
    }
}
