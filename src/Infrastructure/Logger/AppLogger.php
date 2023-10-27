<?php

declare(strict_types=1);

namespace Infrastructure\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger
{
    private static ?Logger $instance = null;

    public static function getInstance(): Logger
    {
        if (self::$instance === null) {
            self::$instance = new Logger('app');
            self::$instance->pushHandler(new StreamHandler(__DIR__ . '/../../../var/logs/app.log', Logger::DEBUG));
        }

        return self::$instance;
    }
}
