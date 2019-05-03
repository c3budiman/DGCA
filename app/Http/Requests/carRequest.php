<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class carRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
