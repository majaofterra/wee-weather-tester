<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MetOfficeController;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather data from MetOffice API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new MetOfficeController();
        if( $controller->cache()){
            $this->info('Weather data cached successfully.');
        } else {
            $this->error('Failed to cache weather data.');
        }
    }
}
