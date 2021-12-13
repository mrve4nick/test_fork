<?php

namespace Framework\core;

class ErrorHandler
{
    public static function logMyErrors($str)
    {
        $log = fopen(__DIR__ . "/../../src/ErrorLog.txt", "a+");
        fwrite($log, $str);
        fwrite($log, ErrorHandler::backtraceExplode());
        fclose($log);
    }

    public static function backtraceExplode()
    {
        $str = "";
        ob_start();
        debug_print_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 10);
        $trace = ob_get_contents();
        ob_end_clean();

        return $trace;
    }


    public static function myErrorHandler()
    {
        set_error_handler(function (int $errNo, string $errMsg, string $file, int $line) {
            ErrorHandler::logMyErrors(time() . " #[$errNo] in [$file] at line [$line]: [$errMsg]\n");
        });

        register_shutdown_function(function () {
            $file = "unknown file";
            $errMsg  = "shutdown";
            $errNo   = E_CORE_ERROR;
            $line = 0;

            $error = error_get_last();
            if ($error !== null) {
                $errNo   = $error["type"];
                $file = $error["file"];
                $line = $error["line"];
                $errMsg  = $error["message"];

                ErrorHandler::logMyErrors(time() . " FATAL Ярик бачок потик #[$errNo], in [$file] at line [$line]: [$errMsg] \n");
            }
        });
    }
}
