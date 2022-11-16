<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;

Route::group([ 'prefix' => 'cliente' ], function() {
    Route::post('/', [ClienteController::class, 'createCliente']);

    Route::put('/{id}', [ClienteController::class, 'editCliente']);

    Route::delete('/{id}', [ClienteController::class, 'deleteCliente']);

    Route::get('/{id}', [ClienteController::class, 'getCliente']);
    Route::get('/consulta/final-placa/{character}', [ClienteController::class, 'getClientesByPlacaLastCharacter']);
});
