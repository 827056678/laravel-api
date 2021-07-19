<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    public function rules()
    {
        switch ($this->method()) {
                // CREATE
            case 'POST':
            case 'PUT':
            case 'PATCH': {
                    //'avatar' => 'mimes:png,jpg,gif,jpeg|dimensions:min_width=208,min_height=208',
                    return [];
                }
            case 'GET':
            case 'DELETE':
            default: {
                    return [];
                }
        }
    }

    public function messages()
    {
        return [];
    }
}
