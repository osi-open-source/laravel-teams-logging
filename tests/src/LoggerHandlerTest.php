<?php
namespace Tests;

use OsiOpenSource\LaravelTeamsLogging\LoggerHandler;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class LoggerHandlerTest extends TestCase
{
    /**
     * @var string
     */
    private $incomingUrl;
    /**
     * @var string
     */
    private $style = 'simple';
    /**
     * @var string
     */
    private $name = 'TeamsLogger';
    /**
     * @var bool
     */
    private $bubble = true;
    /**
     * @var string
     */
    private $format = LoggerHandler::DEFAULT_FORMAT;

    /**
     * @var int
     */
    private $loglevel = Logger::DEBUG;

    public function setUp(): void
    {
        parent::setUp();

        if (!$this->incomingUrl = getenv('TEAMS_INCOMING_WEBHOOK_URL')) {
            throw new \RuntimeException('Please fill in TEAMS_INCOMING_WEBHOOK_URL in phpunit.xml');
        }
    }

    private function createLogHandler()
    {
        return new LoggerHandler($this->incomingUrl, $this->loglevel,$this->style, $this->name, $this->bubble, $this->format);
    }

    public function testInstantiation()
    {
        $logHandler = $this->createLogHandler();

        $this->assertInstanceOf(AbstractProcessingHandler::class, $logHandler);
    }

    public function testUsage()
    {
        $logHandler = $this->createLogHandler();

        $monolog = new Logger('TeamsLogHandlerTest');
        $monolog->pushHandler($logHandler);

        // "isHandling" will return FALSE when no handlers at all are registered with monolog.
        $this->assertTrue($monolog->isHandling($this->loglevel));

        // Send a message
        $result = $monolog->addRecord($this->loglevel, 'test');
        $this->assertTrue($result);
    }
}