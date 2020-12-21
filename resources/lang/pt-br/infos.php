<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Informações
    |--------------------------------------------------------------------------
    |
    | Textos relacionados ao ícone de informação sobre um parâmetro 
    |
    */

    'param_count'               => 'Número de contagens obrigatórias no inventário',
    'param_stock'               => 'Permite ler apenas etiquetas que possuam saldo no sistema.',
    'param_product'             => 'Permite ler apenas produtos que foram selecionados no inventário.',
    'param_location'            => 'Permite ler apenas endereços que foram selecionados no inventário.',
    'param_productdef'          => 'Produto padrão para as contagens do inventário:',
    'param_locationdef'         => 'Endereço padrão para as contagens do inventário.',
    'param_sumprod'             => 'Agrupar as linhas do mesmo produto e somar suas quantidades.',

    /*
    |
    | Textos relacionados ao ícone de informação sobre um botão / ação 
    |
    */
    
    'actions_grid'              => 'Permite salvar / restaurar alterações realizadas no grid de documentos',
    'actions_grid_det'          => 'Permite salvar / restaurar alterações realizadas no grid de detalhes de documentos',
    'liberation_inv'            => 'Documento :doc liberado com sucesso! ( :cont Contagem )',
    'liberation_doc'            => 'Documento :doc liberado com sucesso!',
    'cancel_doc'                => 'Documento :doc cancelado com sucesso!',
    'cancel_docs'               => 'Documentos cancelados com sucesso!',
    'return_doc'                => 'Documento :doc retornado com sucesso!',
    'return_docs'               => 'Documentos retornados com sucesso!',
    'return_location'           => 'Endereço :location retornado com sucesso!',
    'audit_location'           => 'Endereço :location ajustado com sucesso!',
    'select_wave'               => 'Documentos selecionados para Onda:',
    'print_server'              => 'Problemas para visualizar as impressoras disponíveis? ',
    'print_label_type'          => 'Confira o tipo de etiqueta cadastrada para este lote / produto, e se ela possui impressoras cadastradas.',
    'required_fields'           => 'Atenção aos campos obrigatórios não preenchidos! (Inputs com bordas vermelhas)',
    'print_success'             => 'Impressão realizada na fila :printer [:qty Etiqueta(s)].',
    'print_error'               => 'Fila :printer não disponível para impressão.',
    'print_error_def'           => 'Erro ao gerar impressão. Contate o SUPORTE para obter ajuda.',
    'print_select'              => 'Selecione as impressoras que estão ativas e devem ser listadas nos módulos de impressão.',
    'printers_config'           => 'Deseja habilitar outras filas para impressão? ',
    'printers_list'             => 'A impressora desejada não está sendo listada? Verifique se a mesma esta instalada / visível no Windows.',
    'print_server'              => 'Não encontramos o aplicativo de impressão no IP :ip. Verifique se o mesmo está iniciado em seu computador.',

    /*
    |
    | Textos relacionados ao ícone de informação sobre um campo de uma tabela
    |
    */

    'groups.trf_movement'       => 'Caso preenchido, exporta o apontamento/movimentação desse grupo com este valor para o erp/sistema.',    
    'products.origin'           => 'Caso o produto possua grade, indica o código origem (Tamanhos / cores diferentes, por exemplo)',    
    'products.customer_code'    => 'Caso preenchido, indica que é um item específico de um cliente, podendo existir outras linhas com o mesmo código de produto.',    
    'labellayouts.commands'     => 'Este recurso utiliza a API externa Labelary, que pode não funcionar corretamente em algum momento.',    
    

    /*
    |
    | Textos de informações gerais
    |
    */
    
    'attention.import'       => '!! ATENÇÃO: Confirme as informações referentes a cada coluna no arquivo antes de CONTINUAR.',    
    

];
