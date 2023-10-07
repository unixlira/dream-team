<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
                    'max_players'   => 'required|min:1|max:6',
                ]
            :
                [
                    'name'          => 'nullable|string|max:150',
                    'max_players'   => 'nullable|min:1|max:6',
                ]
        ;
    }
}
