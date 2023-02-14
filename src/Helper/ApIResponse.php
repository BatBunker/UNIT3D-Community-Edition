<?php

/**
 * Created by PhpStorm.
 * User: Redeemerr
 * Date: 2/11/23
 * Time: 4:10 AM
 */

declare(strict_types=1);

namespace Src\Helper;

use Symfony\Component\HttpFoundation\Response;

class ApIResponse
{
    public static string $api_version = '1.0.0';

    public function sendResponse($result, $message, int $code = Response::HTTP_OK): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
            'status_code' => $code,
            'api_version' => self::$api_version,


        ];

        return \response()->json($response, $code);
    }


    public function sendError($error, $errorMessages = [], $code = Response::HTTP_NOT_FOUND): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
            'status_code' => $code,
            'api_version' => self::$api_version,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return \response()->json($response, $code);
    }
}
