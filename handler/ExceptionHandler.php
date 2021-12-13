<?php

namespace Framework\core;

use Framework\core\ErrorHandler;

class ExceptionHandler extends \Exception
{
    public function exceptionLog()
    {
        set_exception_handler(function () {
            ErrorHandler::logMyErrors(time() . " EXCEPTION on line " . $this->getLine() . " in " . $this->getFile() . ": " . $this->getMessage() . "\n");
        });
    }
}
