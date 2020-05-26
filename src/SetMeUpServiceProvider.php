<?php

namespace Jdtanjuaquio\Setmeup;

use Illuminate\Support\ServiceProvider;

class SetMeUpServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetMeUpCommand::class,
            ]);
        }
    }
}
