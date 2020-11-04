<?php

namespace OsiOpenSource\LaravelTeamsLogging;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\ScalarFormatter;
use Monolog\Handler\AbstractProcessingHandler;

class LoggerHandler extends AbstractProcessingHandler
{
    public const DEFAULT_FORMAT = "%message%";
    public const ADVANCED_FORMAT = "%message% %context% %extra%";

    /** @var string */
    private $url;

    /** @var string */
    private $style;

    /** @var string */
    private $name;

    /** @var string */
    private $format;

    /**
     * @param string $url
     * @param int|string $level
     * @param string $style
     * @param null|string $name
     * @param bool $bubble
     * @param string $format
     */
    public function __construct(
        string $url,
        $level,
        string $style,
        ?string $name,
        bool $bubble = true,
        string $format = self::DEFAULT_FORMAT
    ) {
        parent::__construct($level, $bubble);

        $this->url = $url;
        $this->style = $style;
        $this->format = $format;
        $this->name = $name;
    }

    /**
     * @return ScalarFormatter|FormatterInterface
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        $formatter = new LineFormatter($this->format);
        $formatter->includeStacktraces();
        return $formatter;
    }


    /**
     * @param array $record
     *
     * @return LoggerMessage
     */
    protected function getMessage(array $record): LoggerMessage
    {
        if ($this->style == 'card') {
            $facts = $this->prepareFacts($record);
            return $this->useCardStyling($record['level_name'], $record['message'], $facts);
        } else {
            return $this->useSimpleStyling($record['level_name'], $record['formatted']);
        }
    }

    /**
     * Styling message as simple message
     *
     * @param string $level
     * @param string $message
     * @param array $facts
     * @return LoggerMessage
     */
    public function useCardStyling(string $level, string $message, array $facts): LoggerMessage
    {
        $loggerColour = new LoggerColour($level);

        return new LoggerMessage([
            'summary' => $level . ($this->name ? ': ' . $this->name : ''),
            'themeColor' => (string)$loggerColour,
            'sections' => [
                array_merge(config('teams.show_avatars', true) ? [
                    'activityTitle' => $this->name,
                    'activityText' => $message,
                    'activityImage' => (string)new LoggerAvatar($level),
                    'facts' => $facts,
                    'markdown' => true
                ] : [
                    'activityTitle' => $this->name,
                    'activityText' => $message,
                    'facts' => $facts,
                    'markdown' => true
                ], config('teams.show_type', true) ? ['activitySubtitle' => '<span style="color:#' . (string)$loggerColour . '">' . $level . '</span>',] : [])
            ]
        ]);
    }

    /**
     * Styling message as simple message
     *
     * @param String $level
     * @param String $message
     */
    public function useSimpleStyling($level, $message): LoggerMessage
    {
        $loggerColour = new LoggerColour($level);

        return new LoggerMessage([
            'text' => ($this->name ? $this->name . ' - ' : '') . '<span style="color:#' . (string)$loggerColour . '">' . $level . '</span>: ' . $message,
            'themeColor' => (string)$loggerColour,
        ]);
    }

    /**
     * @param array $record
     * @return void
     */
    protected function write(array $record): void
    {
        $json = json_encode($this->getMessage($record));

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)
        ]);

        curl_exec($ch);
    }


    /**
     * Create facts name-value pairs
     * @param array $record
     * @return array
     */
    private function prepareFacts(array $record): array
    {
        $facts = [];

        $appendFacts = static function ($array) use (&$facts) {
            foreach ($array as $key => $value) {
                $facts[] = [
                    'name' => $key,
                    'value' => $value,
                ];
            };
        };
        $formatter = new ScalarFormatter();
        $appendFacts($formatter->format($record['context'] ?? []));
        $appendFacts($formatter->format($record['extra'] ?? []));
        return $facts;
    }
}
