<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class mainRequest extends FormRequest
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
