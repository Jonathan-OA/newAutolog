<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    
    //Default
    'show' => 'Mostrando',
    'entries' => 'registros',
    'search' => 'Filtro',
    'first' => 'Primeira',
    'last' => 'Última',
    'previous' => '<',
    'next' => '>',

    //Tables
    'roles' => 'Funções',
    'customers' => 'Clientes',
    'suppliers' => 'Fornecedores',
    'users' => 'Usuários',
    'permissions' => 'Permissões',
    'documents' => 'Documents',
    'items' => 'Produtos',
    'operations' => 'Operações',
    'parameters' => 'Parâmetros',
    'modules' => 'Modulos',
    'user_types' => 'Tipos de Usuários',
    'user_permissions' => 'Permissões de Usuários',
    'packing_types' => 'Tipos de Embalagens',
    'groups' => 'Grupos',
    'product_types' => 'Tipos de Produto',
    'products' => 'Produtos',
    'location_functions' => 'Funções de Endereços',
    'location_types' => 'Tipos de Endereços',
    'deposit_types' => 'Tipos de Depositos',
    'departments' => 'Departamentos',
    'deposits' => 'Depósitos',
    'sectors' => 'Setores',
    'locations' => 'Endereços',
    'stock_types' => 'Tipo de Estoque',
    'stock_type_code' => 'Tipo de Estoque',
    'stocks' => 'Saldo',
    'companies' => 'Empresa',
    'pallets' => 'Paletes',
    'pallet_items' => 'Itens do Palete',
    'configs' => 'Configurações do Sistema',
    'uoms' => 'Unidades de Medida',
    'labels' => 'Etiquetas',
    'finalities' => 'Finalidade (Saldo)',
    'moviments' => 'Movimentos',
    'document_types' => 'Tipos de Documento',
    'packings' => 'Embalagens',
    'packings_types' => 'Tipos de Embalagens',
    'label_types' => 'Tipos de Etiqueta',
    'couriers' => 'Transportadoras',
    'vehicles' => 'Veículos',
    'volumes' => 'Volumes',
    'volume_status' => 'Status de Volumes',
    'pallet_status' => 'Status de Paletes',
    'allowed_transfers' => 'Transferências Permitidas',
    'label_status' => 'Status de Etiquetas',
    'blocked_groups' => 'Grupos Bloqueados por Setor',
    'pallet' => 'Palete',
    'liberation_rules' => 'Regras de Liberação',
    'document_type_rules' => 'Regras de Liberação por Documento',

    //Columns
    'id' => 'ID',
    'name' => 'Nome',
    'description' => 'Descrição',
    'slug' => 'Abreviação',
    'action' => 'Ação',
    'code' => 'Código',
    'number' => 'Número',
    'company_id' => 'Empresa',
    'trading_name' => 'Nome Fantasia',
    'cnpj' => 'CNPJ',
    'address' => 'Endereço',
    'state_registration' => 'Insc. Estadual',
    'neighbourhood' => 'Bairro',
    'city' => 'Cidade',
    'country' => 'País',
    'zip_code' => 'CEP',
    'phone1' => 'Telefone 1',
    'phone2' => 'Telefone 2',
    'active' => 'Ativo',
    'obs1' => 'Obs 1',
    'obs2' => 'Obs 2',
    'obs3' => 'Obs 3',
    'obs4' => 'Obs 4',
    'obs5' => 'Obs 5',
    'state' => 'Estado',
    'type' => 'Tipo',
    'module' => 'Módulo',
    'level' => 'Nível',
    'local' => 'Local',
    'writes_log' => 'Ativa Log',
    'enabled' => 'Status',
    'value' => 'Valor',
    'def_value' => 'Valor Padrão',
    'module_name' => 'Módulo',
    'operation_code' => 'Operação',
    'submodule' => 'Submódulo',
    'icon' => 'Ícone',
    'url' => 'URL',
    'password' => 'Senha',
    'password-confirm' => 'Confirmação da Senha',
    'email' => 'E-mail',
    'user_type_code' => 'Tipo de Usuário',
    'tare' => 'Tara',
    'capacity_kg' => 'Capacidade (Kg)',
    'capacity_m3' => 'Capacidade (M3)',
    'height' => 'Altura',
    'width' => 'Largura',
    'lenght' => 'Comprimento',
    'product_type_code' => 'Tipo de Produto',
    'status' => 'Status',
    'group_code' => 'Grupo',
    'subgroup_code' => 'SubGrupo',
    'margin_div' => 'Divergência',
    'cost' => 'Custo',
    'phase_code' => 'Código da Fase',
    'abz_code' => 'Código ABZ',
    'inventory_date' => 'Ult. Inventário',
    'due_date' => 'Data de Vencimento',
    'critical_date1' => 'Data Crítica 1',
    'critical_date2' => 'Data Crítica 2',
    'critical_date3' => 'Data Crítica 3',
    'ripeness_date' => 'Data de Maturação',
    'capacity_qty' => 'Capacidade (Qde)',
    'length' => 'Comprimento',
    'department_code' => 'Departamento',
    'deposit_code' => 'Depósito',
    'deposit_type_code' => 'Tipo',
    'sector_code' => 'Setor',
    'location_type_code' => 'Tipo de Endereço',
    'location_function_code' => 'Função do Endereço',
    'abz_code' => 'Código ABZ',
    'barcode' => 'Barcode',
    'column' => 'Coluna',
    'aisle' => 'Corredor',
    'label_type_code' => 'Tipo de Etiqueta',
    'sequence_arm' => 'Seq. Armazen.',
    'sequence_sep' => 'Seq. Separação',
    'sequence_inv' => 'Seq. Inventário',
    'depth' => 'Profundidade',
    'branch' => 'Filial',
    'date' => 'Data',
    'location_code' => 'Endereço',
    'document_id' => 'Documento (Id)',
    'stacking' => 'Empilhamento Máximo',
    'packing_type_code' => 'Embalagem',
    'pallet_id' => 'Palete ID',
    'product_code' => 'Item',
    'qty' => 'Quantidade',
    'prim_qty' => 'Qde. Primária',
    'uom_code' => 'Unidade',
    'prim_uom_code' => 'Un. Primária',
    'label_id' => 'Etiqueta',
    'activity_id' => 'Atividade',
    'turn' => 'Turno',
    'client_id' => 'Cliente',
    'origin_product' => 'Produto Origem',
    'origin_label' => 'Etiqueta Origem',
    'origin' => 'Origem',
    'prev_qty' => 'Qde. Anterior',
    'prev_uom_code' => 'Un. Anterior',
    'document_item_id' => 'Item do Documento (Id)',
    'serial_number' => 'Número de Série',
    'batch_number' => 'Lote',
    'batch' => 'Lote',
    'batch_supplier' => 'Lote Fornecedor',
    'prod_date' => 'Data de Fabricação',
    'due_date' => 'Data de Validade',
    'ripeness_date' => 'Data de Maturação',
    'critical_date1' => 'Data Crítica 1',
    'critical_date2' => 'Data Crítica 2',
    'critical_date3' => 'Data Crítica 3',
    'label_status_id' => 'Status',
    'travel_id' => 'Viagem (Id)',
    'task_id' => 'Tarefa (Id)',
    'layout_code' => 'Layout Etq.',
    'weight' => 'Peso',
    'obs1' => 'Obs. 1',
    'obs2' => 'Obs. 2',
    'obs3' => 'Obs. 3',
    'obs4' => 'Obs. 4',
    'obs5' => 'Obs. 5',
    'inventory_date' => 'Ultimo Inventário',
    'product_code' => 'Produto',
    'finality_code' => 'Finalidade',
    'user_code' => 'Usuário',
    'user_id' => 'Usuário (Id)',
    'volume_id' => 'Volume (Id)',
    'moviment_code' => 'Movimento',
    'total_weight' => 'Peso Bruto',
    'total_net_weight' => 'Peso Líquido',
    'capacity_un' => 'Capacidade (UN)',
    'conf_batch' => 'Conf. Lote',
    'conf_batch_supplier' => 'Conf. Lote Fornecedor',
    'conf_serial' => 'Conf. Serial',
    'conf_weight' => 'Conf. Peso',
    'print_label' => 'Imprime Etiqueta',
    'prev_level' => 'Nivel Anterior',
    'total_m3' => 'Total em M3',
    'create_label' => 'Cria Etiqueta (GERAID)',
    'conf_due_date' => 'Conf. Data de Validade',
    'conf_prod_date' => 'Conf. Data de Fabricação',
    'conf_length' => 'Conf. Comprimento',
    'conf_width' => 'Conf. Largura',
    'conf_height' => 'Conf. Altura',
    'volume_status_id' => 'Status',
    'pallet_status_id' => 'Status',
    'orig_department_code' => 'Dept. Origem',
    'orig_deposit_code' => 'Dep. Origem',
    'dest_department_code' => 'Dept. Destino',
    'dest_deposit_code' => 'Dep. Destino',
    'reset_stock' => 'Zera Saldo',
    'export_erp' => 'Exportar ERP',
    'document_type_code' => 'Tipo de Documento Gerado',
    'operation_erp' => 'Operação de Retorno (ERP)',
    'cost_center' => 'Centro de Custo',
    'logical_deposit' => 'Deposito Lógico',
    'active' => 'Ativo',
    'inactive' => 'Inativo',
    'val_integer' => 'Num. Inteiro',
    
    //PlaceHolders
    'sel_type' => 'Selecione um tipo: ',
    'sel_module' => 'Selecione um módulo: ',

    //Gerais
    'entradaManual' => 'Entrada Manual',   
    
    


];
