<?php
/**
 **** ERROR HANDLING ****
 */
error_reporting(0);

// handler for exceptions thrown by trigger_exception
function errorHandler(int $errno, string $errstr): bool {
    if (str_contains($errstr, '400')) {
        $errorCode = 400;
    } else if (str_contains($errstr, '404')) {
        $errorCode = 404;
    } else {
        $errorCode = 500;
    }

    header('X-Error-Message: ' .  $errstr, true, $errorCode);
    die($errstr);
}
set_error_handler("errorHandler");

// handler for fatal errors
function fatalErrorHandler(): void {
    $error = error_get_last();
    if ($error) {
        error_log($error['message']);
        errorHandler(0, '500: Fatal error');
    }
}
register_shutdown_function("fatalErrorHandler");
?>