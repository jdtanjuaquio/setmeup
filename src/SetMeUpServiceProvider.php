<?php

namespace Jdtanjuaquio\Setmeup;

use Illuminate\Support\ServiceProvider;

class SetMeUpServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetMeUpCommand::class,
            ]);
        }
    }

    public function boot()
    {
    }
}
