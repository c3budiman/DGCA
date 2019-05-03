<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class news_digestRequest extends FormRequest
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
