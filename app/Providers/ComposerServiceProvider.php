<?php
/**
 * File: ComposerServiceProvider.php
 * Description: 无
 * User: Alan
 * Datetime: 2017/8/13 17:39
 * Copyright Copyright(c) 2017
 * Version 1.0
 */

namespace App\Providers;

use \Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        \View::composers([
            'App\Http\ViewComposers\ArchviesComposer' => 'home.shared.aside.archives',
            'App\Http\ViewComposers\TagsComposer' => 'home.shared.aside.tags',
            'App\Http\ViewComposers\RecommendComposer' => 'home.shared.aside.recommend',
        ]);

        // Using Closure based composers...
        //View::composer('dashboard', function ($view) {
        //    //
        //});
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}