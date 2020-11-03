<?php

namespace OsiOpenSource\LaravelTeamsLogging;

use Monolog\Logger as MonologLogger;

class Logger extends MonologLogger
{
    /**
     * @param string $url
     * @param int|string $level
     * @param string $style
     * @param null|string $name
     * @param bool $bubble
     * @param string $format
     */
    public function __construct(string $url, $level, string $style, ?string $name, string $bubble, string $format)
    {
        parent::__construct('teams-logger');

        $this->pushHandler(new LoggerHandler($url, $level, $style, $name, $bubble, $format));
    }
}
