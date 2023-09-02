<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Enums\StatusCodeEnum;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse(
        string $status,
        StatusCodeEnum $statusCode,
        $message = null,
        array|object|null $data = []
    ): JsonResponse {
        $response = [
            "status" => $status,
            "message" => $message,
        ];

        if (!empty($data)) {
            $response["data"] = $data;
        }

        return response()->json($response, $statusCode->value);
    }

    public function validateRequest(Request $request, array $rules): object
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $message =
                $validator->messages()->count() == 1
                ? $validator->messages()->first()
                : "Validation error";
            $result =
                $validator->messages()->count() == 1
                ? []
                : $validator->messages()->all();

            return (object) [
                "validated" => false,
                "message" => $message,
            ];
        }

        return (object) [
            "validated" => true,
            "data" => $validator->validated(),
        ];
    }
}
