<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class our_teamRequest extends FormRequest
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
