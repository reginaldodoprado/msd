<?php

use Illuminate\Support\Facades\Route;
use Ds\AssasIntegration\Http\Controllers\AssasController;

/*
|--------------------------------------------------------------------------
| Rotas da API para Assas Integration
|--------------------------------------------------------------------------
|
| Aqui estão definidas as rotas para integração com a API Asaas
|
*/

Route::prefix('api/assas')->group(function () {
    // Criar pagamento
    Route::post('/pagamentos', [AssasController::class, 'criarPagamento']);
    
    // Consultar pagamento
    Route::get('/pagamentos/{paymentId}', [AssasController::class, 'consultarPagamento']);
    
    // Cancelar pagamento
    Route::delete('/pagamentos/{paymentId}', [AssasController::class, 'cancelarPagamento']);
    
    // Listar pagamentos
    Route::get('/pagamentos', [AssasController::class, 'listarPagamentos']);
});
