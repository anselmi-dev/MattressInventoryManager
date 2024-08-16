<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('dimensions', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Dimensions'), route('dimensions.index'));
});

Breadcrumbs::for('parts', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Parts'), route('products.index'));
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

Breadcrumbs::for('combinations', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Combinations'), route('combinations.index'));
});

Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Settings'), route('settings'));
});

Breadcrumbs::for('bases', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Bases'), route('bases.index'));
});

Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Users'), route('users.index'));
});

Breadcrumbs::for('activity', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
    $trail->push(__('Activity'), route('activity.index'));
});