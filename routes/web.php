<?php

use Illuminate\Http\Response;
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

Route::get('/', function (): array {
    return [
        'name' => 'thiagoszbarros/events-backend',
        'type' => 'project',
        'description' => '',
        'authors' => [
            [
                'name' => 'Thiago Barros',
            ],
        ],
        'keywords' => [
            'laravel',
            'framework',
        ],
        'license' => 'MIT',
        'laravel' => app()->version(),
    ];
});

Route::any('{any}', function(): Response{
    return new Response(
        [
            'message' => 'Parece que você está perdido... Rota não encontrada.',
            'data' => null
        ],
        Response::HTTP_NOT_FOUND
    );
})->where('any', '.*');
