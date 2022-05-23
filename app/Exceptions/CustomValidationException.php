<?php

namespace App\Exceptions;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Arr;
use Symfony\Component\HttpFoundation\Response;

class CustomValidationException extends ValidationException
{
    private array $errorData;

    /**
     * Create a new exception instance.
     *
     * @param array         $errorData
     * @param Validator     $validator
     * @param Response|null $response
     * @param string        $errorBag
     */
    public function __construct($errorData, $validator, $response = null, string $errorBag = 'default')
    {
        parent::__construct($validator, $response, $errorBag);
        $this->errorData = $errorData;
    }

    /**
     * Get all of the validation error messages.
     *
     * @return array
     */
    public function errors(): array
    {
        $message = $this->validator->errors()->messages();
        $rulesFailed = $this->validator->failed();

        foreach ($message as $key => &$value) {
            $rule = array_key_first($rulesFailed[$key]);
            if (!class_exists($rule)) {
                $rule = strtolower($rule);
            }
            $errorId = "$key.$rule";
            $errorId = preg_replace('/[0-9]+/', '*', $errorId);

            $value[] = Arr::get($this->errorData, $errorId, 'SJM-COM-422');
        }

        return $message;
    }
}
