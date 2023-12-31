<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'email'     => 'required|unique:users,email',
                    'name'      => 'required',
                    'phone'     => 'required|unique:users,phone',
                    'password'  => 'required',
                    'img_profile'  => 'nullable',


                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name'      => 'nullable',
                    'phone'     => ['nullable',Rule::unique('users')->ignore($this->phone)],
                    'password'  => 'nullable',
                   
                ];
            default:
                return [];
        }
    }
}
