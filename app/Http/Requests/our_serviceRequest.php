<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class our_serviceRequest extends FormRequest
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
