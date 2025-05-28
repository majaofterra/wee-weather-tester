<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Wee Beastie

A Laravel + Vue app for fetching and displaying weather data from the Met Office API for various "Dundee" locations around the world. By Jamie MacDonald

---

## Features

- Fetches weather data from the Met Office API
- Caches weather data for performance
- Displays weather predictions with icons
- Supports multiple "Dundee" locations
- Uses Font Awesome for weather icons

---

## Requirements

- Met Office API Details
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL or other supported database

---

## Installation

1. **The Setup:**
    ```sh
    git clone https://github.com/majaofterra/wee-weather-tester.git
    cd wee-weather-tester/
    composer install
    npm install
    cp .env.example .env
    ```

2. **Configure Your Environment:**
    - Set your Met Office API key and DB details in `.env`:

3. **Finish Up:**
    ```sh
    php artisan key:generate
    php artisan migrate
    php artisan app:get-weather
    npm run build
    php artisan serve
    ```

4. **(Optional) Seed the database and config docker:**
    ```sh
    php artisan db:seed
    vim Dockerfile
    ```

---

## Usage

- Visit [http://localhost:8000](http://localhost:8000) in your browser.
- Weather data will be fetched and displayed for a random "Dundee" location.
- To manually fetch new weather data, run:
    ```sh
    php artisan app:get-weather
    ```
- Weather data is cached for 6 hours.

---

## Font Awesome Icons

Font Awesome Free is included via npm. You can use any free icon in your Vue components with:
```html
<i class="fas fa-sun"></i>
```

---

## Scheduling

To fetch weather data automatically every hour, add this to your server's crontab:
```
* * * * * cd /path/to/wee-beastie && php artisan schedule:run >> /dev/null 2>&1
```

---

## Configuration

- **Weather thresholds:** `config/weather_thresholds.php`
- **Dundee locations:** `config/dundees.php`
- **Weather types:** `config/types.php`

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
