<?php

use App\Models\{
    Combination,
    Cover,
    Dimension,
    Base,
    Top,
};
use Illuminate\Support\Facades\Cache;

if (!function_exists('count_tops')) {
    function count_tops ()
    {
        return Cache::remember('count:tops', 100, function () {
            return Top::visible()->count();
        });
    }
}

if (!function_exists('count_dimensions')) {
    function count_dimensions ()
    {
        return Cache::remember('count:dimensions', 100, function () {
            return Dimension::visible()->count();
        });
    }
}

if (!function_exists('count_bases')) {
    function count_bases ()
    {
        return Cache::remember('count:bases', 100, function () {
            return Base::visible()->count();
        });
    }
}

if (!function_exists('count_covers')) {
    function count_covers ()
    {
        return Cache::remember('count:covers', 100, function () {
            return Cover::visible()->count();
        });
    }
}

if (!function_exists('count_tops')) {
    function count_combinations ()
    {
        return Cache::remember('count:tops', 100, function () {
            return Top::count();
        });
    }
}

if (!function_exists('count_combinations')) {
    function count_combinations ()
    {
        return Cache::remember('count:combinations', 100, function () {
            return Combination::count();
        });
    }
}

if (!function_exists('appendCentimeters')) {
    function appendCentimeters (int|string $number)
    {
        $number = str_replace('.00', '', $number);

        return "{$number}cm";
    }
}