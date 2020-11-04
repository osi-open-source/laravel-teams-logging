<?php

namespace OsiOpenSource\LaravelTeamsLogging;

use Monolog\Logger as MonologLogger;

class LoggerChannel
{
    /**
     * @param array $config
     *
     * @return Logger
     */
    public function __invoke(array $config)
    {
        return new Logger(
            $config['url'],
            $config['level'] ?? MonologLogger::DEBUG,
            $config['style'] ?? 'simple',
            $config['name'] ?? null,
            $config['bubble'] ?? true,
            $config['format'] ?? LoggerHandler::DEFAULT_FORMAT
        );
    }
}
