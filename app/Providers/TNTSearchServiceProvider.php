<?php

namespace App\Providers;

use App\Services\Search\TNTSearchEngine;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use TeamTNT\TNTSearch\TNTSearch;

class TNTSearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        resolve(EngineManager::class)->extend('tntsearch', function () {
            $tnt = new TNTSearch();

            $tnt->loadConfig([
                'driver' => 'mysql',
                'host' => config('database.connections.mysql.host'),
                'database' => config('database.connections.mysql.database'),
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
                'storage' => storage_path('app/'),
                'stemmer' => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class,
            ]);

            return new TNTSearchEngine($tnt);
        });
    }
}
