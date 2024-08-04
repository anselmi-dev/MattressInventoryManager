<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('dimensions', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Dimensions'), route('dimensions.index'));
});

Breadcrumbs::for('tops', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Tops'), route('tops.index'));
});

Breadcrumbs::for('sales', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Sales'), route('sales.index'));
});

Breadcrumbs::for('covers', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Covers'), route('covers.index'));
});

Breadcrumbs::for('mattresses', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Mattresses'), route('mattresses.index'));
});

Breadcrumbs::for('combinations', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Combinations'), route('combinations.index'));
});