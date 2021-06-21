<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Http\Requests\CaptchaRequest;
use App\Http\Requests\CaptchaVerificationRequest;
use Illuminate\Support\Facades\Cache;

class CaptchasController extends Controller
{
    public function index(CaptchaRequest $request)
    {
        $key = 'captcha-' . Str::random(15);
        // $phone = ltrim(phone($request->phone, 'CN', 'E164'), '+86');
        $phraseBuilder = new PhraseBuilder(4, '0123456789');
        $captchaBuilder = new CaptchaBuilder(null, $phraseBuilder);
        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);
        // Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);
        Cache::put($key, ['code' => $captcha->getPhrase()], $expiredAt);
        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];

        return $this->setStatusCode(201)->success($result);
    }


    public function verification(CaptchaVerificationRequest $request)
    {
        $captchaData = Cache::get($request->captcha_key);
        if (!$captchaData) {
            return $this->setStatusCode(403)->failed('验证码图片已失效');
        }
        if (!hash_equals(Str::lower($captchaData['code']), Str::lower($request->captcha_code))) {
            // 验证错误就清除缓存
            return $this->failed('验证码错误');
        }
        Cache::forget($request->captcha_key);
        return $this->success('验证成功');
    }
}
