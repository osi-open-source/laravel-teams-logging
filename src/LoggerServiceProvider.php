<?php

namespace OsiOpenSource\LaravelTeamsLogging;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * The Laravel application instance.
     *
     * @var Container
     */
    protected $app;

    /**
     * Normalized Laravel Version
     *
     * @var string
     */
    protected $version;

    /**
     * True when booted.
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * True when enabled, false disabled an null for still unknown
     *
     * @var bool
     */
    protected $enabled = null;

    /**
     * True when this is a Lumen application
     *
     * @var bool
     */
    protected $is_lumen = false;

    /**
     * @param Container $app
     */
    public function __construct($app = null)
    {
        if (!$app && function_exists('app')) {
            $app = app();   //Fallback when $app is not given
        }
        $this->app = $app;
        $this->version  = $app->version();
        $this->is_lumen = Str::contains($this->version, 'Lumen');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->booted) {
            return;
        }

        $this->publishes([
            __DIR__ . '/config/teams.php' => $this->app->basePath() . '/config/teams.php',
        ]);
    }
}
