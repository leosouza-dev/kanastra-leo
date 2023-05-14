<?php

namespace App\src\Application\UseCases;

class ImportDebtListUseCase
{
  // chama repositório para buscar devedores no banco (status != de paid);
  // gerar boleto para devedores;
  // chama serviço para enviar email - deve pegar o email do devedor;
}