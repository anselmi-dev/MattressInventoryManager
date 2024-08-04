<?php

use App\Models\Combination;
use App\Models\Cover;
use App\Models\Dimension;
use App\Models\Mattress;
use App\Models\Top;
use Illuminate\Support\Facades\Cache;

if (!function_exists('count_tops')) {
    function count_tops ()
    {
        return Cache::remember('count:tops', 100, function () {
            return Top::available()->count();
        });
    }
}

if (!function_exists('count_dimensions')) {
    function count_dimensions ()
    {
        return Cache::remember('count:dimensions', 100, function () {
            return Dimension::available()->count();
        });
    }
}

if (!function_exists('count_mattresses')) {
    function count_mattresses ()
    {
        return Cache::remember('count:mattresses', 100, function () {
            return Mattress::available()->count();
        });
    }
}

if (!function_exists('count_covers')) {
    function count_covers ()
    {
        return Cache::remember('count:covers', 100, function () {
            return Cover::available()->count();
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
