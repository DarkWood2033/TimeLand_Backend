<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Route;
use File;
use Illuminate\Support\Arr;

class RouteJsonApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:json_api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate json api route for js.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = Route::getRoutes()->getRoutesByName();
        $result = [];

        foreach ($routes as $route){
            Arr::set($result, $route->getName(), [
                'url' => $route->uri,
                'method' => $route->methods[0],
            ]);
        }

        File::put(
            'resources/site/js/configs/routesApi.js',
            'export default '.json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).';');

        $this->comment('Конфигурация успешно создана!');
    }

    private function getResource(){}
}
