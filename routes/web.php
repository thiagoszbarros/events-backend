<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'web' middleware group. Make something great!
|
*/

Route::get('/', function () {
    return [
        'name' => 'thiagoszbarros/events-backend',
        'type' => 'project',
        'description' => '',
        'authors' => [
            [
                'name' => 'Thiago Barros'
            ]
        ],
        'keywords' => [
            'laravel',
            'framework'
        ],
        'license' => 'MIT',
        'laravel' => app()->version(),
    ];
});
