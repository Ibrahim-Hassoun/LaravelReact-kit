<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseFormRequest;
class RegisterRequest extends BaseFormRequest
{
    public function rules(): array
    {
          return [
        'name' => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|string|min:6',
        
    ];
    }
}
