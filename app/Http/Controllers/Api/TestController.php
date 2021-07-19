<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\Services\UploadService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request, UploadService $service)
    {
        if ($request->avatar) {
            $result = $service->save($request->avatar, 'avatar', 1, 500);
            if ($result) {
                return $this->success($result);
            }
        }
    }
}
