<?php
/*
Logger
Singleton for setting up logging
*/

require_once "KLogger.php";

// Singleton class for logging
class LoggerSingleton
{
    /* Logging parameters */
    const LoggingLevel = KLogger::INFO;
    const LogFile = "todo_trace.log";

    /* My static instance */
    private static $instance;

    /* create instance */
    public static function GetInstance()
    {
        if(null == static::$instance)
        {
            static::$instance = new KLogger(self::LogFile, self::LoggingLevel);
        }

        return static::$instance;
    }

    /* block out object construction */
    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}



?>
