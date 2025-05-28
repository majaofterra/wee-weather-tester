<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show the application welcome page.
     */
    public function index()
    {
        $latestWeather = Cache::get('weather_response');
        $thresholds = config('weather_thresholds');
        $icons = config('weather_icons');
        $data = [];

        if ($latestWeather && isset($latestWeather['features'][0]['properties']['timeSeries'])) {
            $dundee = $latestWeather['features'][0]['geometry']['coordinates'];

            foreach (array_slice($latestWeather['features'][0]['properties']['timeSeries'], 1, 5) as $timeSeries) {
                $dateObj = Carbon::parse($timeSeries['time']);
                $date = $dateObj->format('D, j');

                try {
                    if ($timeSeries['dayUpperBoundMaxFeelsLikeTemp'] > $thresholds['hot_temp']) {
                        $data[$date]['icons']['tempture'] = $icons['hot'];
                    } elseif ($timeSeries['dayLowerBoundMaxFeelsLikeTemp'] < $thresholds['cold_temp']) {
                        $data[$date]['icons']['tempture'] = $icons['cold'];
                    } else {
                        $data[$date]['icons']['tempture'] = $icons['normal'];
                    }
                    if ($timeSeries['dayProbabilityOfRain'] > $thresholds['rain_probability'])
                        $data[$date]['icons']['rain'] = $icons['rain'];
                    if ($timeSeries['midday10MWindSpeed'] > $thresholds['wind_speed'])
                        $data[$date]['icons']['wind'] = $icons['wind'];
                    if ($timeSeries['dayProbabilityOfSnow'] > $thresholds['snow_probability'])
                        $data[$date]['icons']['snow'] = $icons['snow'];
                    if ($timeSeries['dayProbabilityOfHail'] > $thresholds['hail_probability'])
                        $data[$date]['icons']['hail'] = $icons['hail'];

                    switch ($timeSeries['daySignificantWeatherCode']) {
                        case -1:
                        case 0:
                        case 2:
                        case 4:
                        case 5:
                        case 6:
                        case 11:
                        case 18:
                        case 20:
                        case 23:
                        case 25:
                        case 30:
                            $data[$date]['findWeeBeasty'] = true;
                            break;
                        default:
                    }
                    if ($dateObj->format('d-m') === '25-01') {
                        $data[$date]['findWeeBeasty'] = true;
                    }

                    $data[$date]['data']['temperature-high'] = $timeSeries['dayUpperBoundMaxFeelsLikeTemp'] . ' ' . $latestWeather['parameters'][0]['dayUpperBoundMaxFeelsLikeTemp']['unit']['symbol']['type'];
                    $data[$date]['data']['temperature-low'] = $timeSeries['dayLowerBoundMaxFeelsLikeTemp'] . ' ' . $latestWeather['parameters'][0]['dayLowerBoundMaxFeelsLikeTemp']['unit']['symbol']['type'];
                    $data[$date]['data']['cloud-rain'] = $timeSeries['dayProbabilityOfRain'] . ' ' . $latestWeather['parameters'][0]['dayProbabilityOfRain']['unit']['symbol']['type'];
                    $data[$date]['data']['wind'] = $timeSeries['midday10MWindSpeed'] . ' ' . $latestWeather['parameters'][0]['midday10MWindSpeed']['unit']['symbol']['type'];

                    $data[$date]['type'] = config('types.' . $timeSeries['daySignificantWeatherCode']);
                } catch (\Exception $e) {
                }
            }
        }

        if (empty($dundee))
            return 'Dundee not found, run the cache.';

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => app()->version(),
            'phpVersion' => PHP_VERSION,
            'weatherData' => $data,
            'here' => $dundee,
        ]);
    }
}
