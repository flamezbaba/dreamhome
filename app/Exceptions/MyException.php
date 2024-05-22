<?php
namespace App\Exceptions;

class MyException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}
