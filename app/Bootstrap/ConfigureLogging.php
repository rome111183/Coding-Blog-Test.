<?php

namespace App\Bootstrap;

use Monolog\Logger as Monolog;
use Monolog\Formatter\LineFormatter;
use Illuminate\Log\Writer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigureLogging;
use Monolog\Handler\StreamHandler;

class ConfigureLogging extends BaseConfigureLogging
{
    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureSingleHandler(Application $app, Writer $log)
    {
        $log->useFiles(
            $app->storagePath().'/logs/all.log',
            $app->make('config')->get('app.log_level', 'debug')
        );
    }

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureDailyHandler(Application $app, Writer $log)
    {
        // Gathering
        $bubble = false;
        $monolog = $log->getMonolog();

        // Default
        $log_path = "/logs/";
        $log_path = storage_path($log_path.date('Y-m')."/");
        $log_path = str_replace("\\","/",$log_path);

        if(!is_dir($log_path)) {
            @mkdir($log_path, 0755, true);
        }

        $monolog->pushHandler(new StreamHandler( $log_path.'debug-'.date('Y-m-d').".log", Monolog::DEBUG, $bubble));
        $monolog->pushHandler(new StreamHandler( $log_path.date('Y-m-d').".log", Monolog::INFO, $bubble));
    }
}