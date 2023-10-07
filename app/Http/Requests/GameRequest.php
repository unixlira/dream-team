<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->method() === 'POST'
            ?
                [
                    'name'          => 'required|string|max:150',
                ]
            :
                [
                    'name'          => 'nullable|string|max:150',
                ]
        ;
    }
}
