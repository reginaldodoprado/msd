<?php

use Illuminate\Support\Facades\Route;
use Ds\AssasIntegration\Http\Controllers\PaymentController;

// Rota para processar PIX (sem middleware, verificação manual)
Route::get('/assas/pix/process', [PaymentController::class, 'processPix'])
    ->name('assas.pix.process')
    ->middleware('web');

// Rota para processar Cartão de Crédito (sem middleware, verificação manual)
Route::get('/assas/cartao/process', [PaymentController::class, 'processCartao'])
    ->name('assas.cartao.process')
    ->middleware('web');

// Rota para processar Boleto (sem middleware, verificação manual)
Route::get('/assas/boleto/process', [PaymentController::class, 'processBoleto'])
    ->name('assas.boleto.process')
    ->middleware('web');

// Rota de sucesso para PIX e Cartão (retorno do Asaas)
Route::get('/assas/success', [PaymentController::class, 'success'])
    ->name('assas.success')
    ->middleware('web');

// Webhook do Asaas (sem middleware para receber notificações)
Route::post('/assas/webhook', [PaymentController::class, 'webhook'])->name('assas.webhook');

// Rota de sucesso para boleto
Route::get('/assas/boleto/success', [PaymentController::class, 'boletoSuccess'])
    ->name('assas.boleto.success')
    ->middleware('web');
