<?php


namespace App\Exceptions;

use Throwable;

class CustomException extends \Exception
{
    private string $errorCode;

    /**
     * CustomException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param string         $errorCode
     * @param null|Throwable $previous
     */
    public function __construct(
        $message = "Unauthenticated.",
        $code = 401,
        string $errorCode = "SJM-COM-401",
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
