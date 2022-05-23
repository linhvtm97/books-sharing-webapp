<?php


namespace App\Traits;

use App\Exceptions\CustomValidationException;
use App\Utils\HttpCodeTransform;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

trait ResponseTrait
{
    /**
     * @param mixed  $data
     * @param int    $status
     * @param string $transCode
     *
     * @return JsonResponse
     */
    public function success($data, int $status = 200, $transCode = ''): JsonResponse
    {
        if (isset($data->resource)) {
            if ($data->resource instanceof LengthAwarePaginator) {
                $paginationData = $data->resource->toArray();

                return response()->json([
                    'message' => HttpCodeTransform::STATUS_CODE[$status],
                    'data' => $data->resource->items(),
                    'pagination' => array_diff_key($paginationData, array_flip(['data', 'links'])),
                    'links' => $data->resource->linkCollection()->toArray()
                ], $status);
            }
        }

        if (!empty($transCode)) {
            return response()->json(['data' => $data, 'code' => $transCode], $status);
        }

        return response()->json(['data' => $data, 'code' => 'SJM-COM-200'], $status);
    }

    /**
     * @param string $message
     * @param int    $statusCode
     * @param string $transCode
     *
     * @return JsonResponse
     */
    public function successWithMessage(string $message = 'OK', $statusCode = 200, $transCode = ''): JsonResponse
    {
        if (!empty($transCode)) {
            return response()->json([
                'data' => [
                    'message' => $message,
                    'status' => 'OK',
                    'code' => $transCode
                ]
            ]);
        }
        if ($statusCode === JsonResponse::HTTP_CREATED) {
            return response()->json([
                'data' => [
                    'message' => $message,
                    'status' => 'OK',
                    'code' => 'SJM-COM-201'
                ]
            ]);
        }

        return response()->json([
            'data' => [
                'message' => $message,
                'status' => 'OK',
                'code' => 'SJM-COM-200'
            ]
        ]);
    }

    /**
     * @param string $errorCode
     * @param string $message
     * @param int    $status
     * @param array  $error
     *
     * @return JsonResponse
     */
    public function error(string $errorCode, string $message, int $status = 500, array $error = []): JsonResponse
    {
        $res = [
            'error' => [
                'status_code' => $status,
                'code' => HttpCodeTransform::STATUS_CODE[$status],
                'message' => $message,
                'error_code' => $errorCode,
                'errors' => $error
            ],
        ];

        return response()->json($res, $status);
    }

    /**
     * @param Throwable|Exception $e
     * @param int                 $status
     * @param array               $error
     *
     * @return JsonResponse
     */
    public function errorException($e, int $status = 500, array $error = []): JsonResponse
    {
        $res = [
            'error' => [
                'status_code' => $status,
                'code' => HttpCodeTransform::STATUS_CODE[$status],
                'message' => $status != JsonResponse::HTTP_UNPROCESSABLE_ENTITY ?
                    $e->getMessage() : $error[0]['message'],
                'error_code' =>  $status != JsonResponse::HTTP_UNPROCESSABLE_ENTITY ?
                    "SJM-COM-$status" : $error[0]['error_code'],
                'errors' => $error
            ],
        ];

        return response()->json($res, $status);
    }


    /**
     * @param HttpException $e
     *
     * @return JsonResponse
     */
    public function httpException(HttpException $e): JsonResponse
    {
        return $this->errorException($e, $e->getStatusCode());
    }

    /**
     * @param CustomValidationException $validator
     *
     * @return JsonResponse
     */
    public function validationException(CustomValidationException $validator): JsonResponse
    {
        $errors = [];
        foreach ($validator->errors() as $field => $message) {
            $errors[] = [
                'field' => $field,
                'error_code' => Arr::last($message),
                'message' => Arr::first($message)
            ];
        }

        return $this->errorException($validator, $validator->status, $errors);
    }
}
