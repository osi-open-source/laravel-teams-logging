<?php

namespace OsiOpenSource\LaravelTeamsLogging;

class LoggerAvatar
{
    const EMERGENCY = 'https://api.hello-avatar.com/adorables/face/eyes7/nose7/mouth7/721C24';
    const ALERT     = 'https://api.hello-avatar.com/adorables/face/eyes7/nose7/mouth6/721C24';
    const CRITICAL  = 'https://api.hello-avatar.com/adorables/face/eyes7/nose7/mouth5/721C24';
    const ERROR     = 'https://api.hello-avatar.com/adorables/face/eyes7/nose7/mouth9/721C24';
    const WARNING   = 'https://api.hello-avatar.com/adorables/face/eyes6/nose7/mouth10/721C24';
    const NOTICE    = 'https://api.hello-avatar.com/adorables/face/eyes6/nose7/mouth3/721C24';
    const INFO      = 'https://api.hello-avatar.com/adorables/face/eyes5/nose7/mouth1/721C24';
    const DEBUG     = 'https://api.hello-avatar.com/adorables/face/eyes5/nose7/mouth1/721C24';

    /** @var string */
    private $const;

    /**
     * @param $const
     */
    public function __construct($const = 'DEBUG')
    {
        $this->const = $const;
    }

    /**
     * @return String
     */
    public function __toString()
    {
        return config('teams.avatars.' . strtolower($this->const), constant('self::' . $this->const));
    }
}
