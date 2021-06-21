<?php

namespace App\Http\Requests;

class CaptchaRequest extends Request
{
    public function rules()
    {
        return [
            // 'phone' => 'required|phone:CN,mobile|unique:users',
        ];
    }
}
