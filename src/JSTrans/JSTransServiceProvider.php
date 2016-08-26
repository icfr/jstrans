<?php

namespace MisterPaladin\JSTrans;

use Blade;
use Illuminate\Support\ServiceProvider;
use MisterPaladin\Console\JSTransPublish;

class JSTransServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->publishes([
            __DIR__ . '/../config.php' => config_path('jstrans.php'),
        ], 'jstrans');

        $this->app['command.jstrans.publish'] = $this->app->share(
            function ($app) {
                return new JSTransPublish($app['config'], $app['translator']);
            }
        );

        $this->commands('command.jstrans.publish');

        Blade::directive('jstrans', function ($expression) {
            return '<?php
                $exp = ' . $expression . ';
                foreach ($exp as $key => $value) {
                    echo "<input type=\"hidden\" disabled=\"disabled\" name=\"jstrans-value-for-$key\" value=\"$value\" />";
                }
            ?>';
        });
    }
}
