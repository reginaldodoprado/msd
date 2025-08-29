<?php

namespace Ds\AssasIntegration\Services;

use Ds\AssasIntegration\Services\ApiClientService;

class TransacoesPixService
{
    protected $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

   /**
    * Pagar um qr code pix
    */
   public function pagarQrCodePix(array $dados)
   {
    return $this->apiClient->post("pix/qrCodes/pay", $dados);
   }

   /**
    * Decodificar para pagar um qr code pix
    */
   public function decodificarParaPagarQrCodePix(array $dados)
   {
    return $this->apiClient->post("pix/qrCodes/decode", $dados);
   }
   
   /**
    * Recuperar uma unica transação pix
    */
   public function recuperarUmaUnicaTransacaoPix(string $id)
   {
    return $this->apiClient->get("pix/transactions/{$id}");
   }

   /**
    * Listar transações pix
    */
   public function listarTransacoesPix(array $filtros = [])
   {
    return $this->apiClient->get("pix/transactions", $filtros);
   }

   /**
    * Cancelar uma transação pix agendada
    */
   public function cancelarTransacaoPixAgendada(string $id)
   {
    return $this->apiClient->post("pix/transactions/{$id}/cancel");
   }
   
   
}