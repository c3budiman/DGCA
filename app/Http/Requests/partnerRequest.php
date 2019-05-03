<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class partnerRequest extends FormRequest
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
