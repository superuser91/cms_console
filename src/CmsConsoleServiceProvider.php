<?php

namespace Vgplay\CmsConsole;

use Illuminate\Support\ServiceProvider;

class CmsConsoleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/configs/cms_console.php', 'cms_console');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'cms_console');
    }
}
