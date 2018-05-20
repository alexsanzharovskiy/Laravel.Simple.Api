<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $msg
     * @return \Illuminate\Http\JsonResponse
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    protected function errorResponse(string $msg)
    {
        return response()->json([
            'data' => [
                'error' => (string)$msg
            ]
        ]);
    }

    /**
     * @param $requestParams
     * @param $rulesParams
     * @return bool
     * @author Alexandr Sanzharovskiy <meylah15@gmail.com>
     */
    protected function isValidRequest($requestParams, $rulesParams)
    {
        $validator = Validator::make($requestParams, $rulesParams);

        return (bool) !$validator->fails();
    }
}
