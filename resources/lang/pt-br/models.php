<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | Textos relacionados a nomes de tabelas, colunas e algumas informações gerais.
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
    'operations' => 'Operações',
    'parameters' => 'Parâmetros',
    'options' => 'Opções',
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
    'liberation_items' => 'Itens de Liberação do Documento',
    'blocked_locations' => 'Produtos Bloqueados em Endereços',
    'blocked_operations' => 'Produtos Bloqueados em Operações',
    'document_status' => 'Status de Documentos',
    'document_items' => 'Itens do Documento',
    'logs' => 'Logs do Sistema',
    'graphs' => 'Gráficos',
    'notifications' => 'Notificações',
    'task_status' => 'Status de Tarefas',
    'tasks' => 'Tarefas',
    'activities' => 'Atividades',
    'activity_status' => 'Status de Atividades',
    'liberation_status' => 'Status de Liberação',
    'inventory_status' => 'Status de Inventário',
    'printer_types' => 'Tipos de Impressora',
    'label_layouts' => 'Layouts de Etiqueta',
    'label_variables' => 'Variáveis de Etiqueta',

    
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
    'liberation_status_id' => 'Status',
    'orig_location_code' => 'Endereço Origem',
    'dest_location_code' => 'Endereço Destino',
    'task_id' => 'Tarefa',
    'courier_code' => 'Transportadora',
    'supplier_code' => 'Fornecedor',
    'customer_code' => 'Cliente',
    'document_status_id' => 'Status',
    'comments' => 'Observações',
    'lib_automatic' => 'Lib. Automática',
    'lib_location' => 'Lib. com End. Destino',
    'num_automatic' => 'Numeração Automática na Criação',
    'print_labels' => 'Tela de Impressão de Etiquetas',
    'print_labels_doc' => 'Tela de Impressão de Documento',
    'operation_code_doc' => 'Tarefa Principal a ser Criada na Liberação',
    'partial_lib' => 'Liberação de Saldo Parcial',
    'lib_deposits' => 'Depósitos Válidos',
    'qty_conf' => 'Quantidade Conferida',
    'qty_doc' => 'Qde. Solicitada',
    'qty_ship' => 'Quantidade Embarcada',
    'qty_reject' => 'Quantidade Rejeitada',
    'qty_print' => 'A Imprimir',
    'qty_printed' => 'Impressas',
    'invoice' => 'Nota Fiscal',
    'invoice_serial_number' => ' N. Série da Nota Fiscal',
    'created_at' => 'Data',
    'emission_date' => 'Data de Emissão',
    'source' => 'Origem',
    'sequence_item' => 'SeqItem',
    'title' => 'Título',
    'color' => 'Cor',
    'user_code' => 'Usuário',
    'start_date' => 'Data de Início',
    'end_date' => 'Data de Fin.',
    'task_status_id' => 'Status',
    'reason_id' => 'Motivo',
    'pallet_barcode' => 'Palete',
    'document_number' => 'Documento',
    'stock_transfer' => 'Transferência Manual',
    'decimal_places' => 'Casas Decimais',
    'order' => 'Ordem de Exc.',
    '1acount' => '1ª Cont.',
    '2acount' => '2ª Cont.',
    '3acount' => '3ª Cont.',
    '4acount' => '4ª Cont.',
    'qty_wms' => 'Saldo Previsto',
    'trf_movement' => 'Movimento de Exportação (ERP)',
    'printer_type_code' => 'Tipo de Impressora',
    'commands' => 'Comandos de Impressão',
    'across' => 'Carreiras',
    'size' => 'Tamanho Máximo',
    'size_start' => 'Posição de Início',
    'table' => 'Tabela',
    'field' => 'Campo',
    'inspection' => 'Inspeção',
    'finalization' => 'Finalização Hab.',
    'due_days' => 'Dias Mín. para Vencimento',
    'prefix_code' => 'Prefixo para Produtos',
    
    //PlaceHolders
    'sel_type' => 'Selecione um tipo: ',
    'sel_module' => 'Selecione um módulo: ',

    //Gerais
    'entradaManual' => 'Entrada Manual',  
    'production' => 'Módulo de Produção',  
    'receipt' => 'Módulo de Recebimento',  
    'separation' => 'Módulo de Separação',  
    'inventory' => 'Módulo de Inventário',  
    'transfer' => 'Módulo de Transferência',  
    'document_edit' => 'Documento: ',  
    'document_create' => 'Criação de Documento',  
    'document_lib' => 'Liberação de Documento',  
    'document_imp' => 'Importação de Documento',  
    'document_exp' => 'Exportação de Documento',  
    'pre_document_imp' => 'Importação de Documento - Confirmação',  
    'item_create' => 'Criação de Item',  
    'item_edit' => 'Edição de Item',  
    'items' => 'Itens',
    'items_doc' => 'Itens do Documento',
    'dashboard' => 'Dashboard',
    'support' => 'Suporte',
    'message' => 'Mensagem',
    'barcode_orig' => 'Palete / Etiqueta Origem',
    'barcode_dest' => 'Palete / Endereço Destino',
    'label_barcode' => 'Etiqueta',
    'stock' => 'Saldo',
    'items_select' => 'Seleção de Itens',
    'yes' => 'Sim',
    'no' => 'Não',
    'reports' => 'Relatórios',
    'traceability' => 'Rastreabilidade ',
    'viewer' => 'Pré-Visualização ',
    'print' => 'Impressão de Etiquetas ',
    'print_doc' => 'Imprimir Documento ',
    'printer' => 'Impressora',
    'printConfig' => 'Configuração de Impressoras',
    'total' => 'Total ',
    'fileExcel' => 'Planilha Excel ',
    'fileInput' => 'Arquivo de Entrada ',
    'fileXml' => 'Arquivo XML ',
    'users_online' => 'Usuários Online',
    'infos_import' => 'Informações Presentes no Arquivo',
    'cost_inventory' => 'Valor',
    'profile_export' => 'Perfil de Exportação',
    'delimiter' => 'Delimitador',
    'billing_type' => 'Tipo de Cobrança',
    


];
