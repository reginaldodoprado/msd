<?php

use Illuminate\Support\Facades\Route;
use Ds\AssasIntegration\Http\Controllers\TesteAssasController;

/*
|--------------------------------------------------------------------------
| Rotas Web para Teste do AssasIntegration
|--------------------------------------------------------------------------
|
| Rotas para testar o pacote via interface web
|
*/

Route::prefix('assas')->name('assas.')->group(function () {
    // View de teste
    Route::get('/teste', [TesteAssasController::class, 'index'])->name('teste');
    
    // Testar pagamento
    Route::post('/testar-pagamento', [TesteAssasController::class, 'testarPagamento'])->name('testar-pagamento');
    
    // Testar conexão
    Route::get('/testar-conexao', [TesteAssasController::class, 'testarConexao'])->name('testar-conexao');
    
    // Gerenciar customers
    Route::get('/customers', [TesteAssasController::class, 'listarCustomers'])->name('listar-customers');
    Route::post('/customers', [TesteAssasController::class, 'criarCustomer'])->name('criar-customer');
});
