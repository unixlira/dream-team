<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
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
                    'skill_level'   => 'required|numeric|min:1|max:5',
                    'is_goalkeeper' => 'required|in:0,1',
                    'is_presence'   => 'nullable|in:0,1',
                ]
            :
                [
                    'name'          => 'nullable|string|max:150',
                    'skill_level'   => 'nullable|numeric|min:1|max:5',
                    'is_goalkeeper' => 'nullable|in:0,1',
                    'is_presence'   => 'nullable|in:0,1',
                ]
        ;
    }
}
