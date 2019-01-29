<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => ':attributes não conferem.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'O valor do campo :attribute não existe no sistema.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'O campo :attribute não pode ultrapassar :max caracteres.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'O campo :attribute precisa ter pelo menos :min kilobytes.',
        'string'  => 'O campo :attribute precisa ter pelo menos :min caracteres.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'O valor selecionado no campo :attribute é inválido.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ' :attribute já cadastrado.',
    'url'                  => 'The :attribute format is invalid.',
    'save_success'         => 'Registro adicionado com sucesso.',
    'update_success'         => 'Registro atualizado com sucesso.',
    'delete_success'         => 'Registro excluído com sucesso.',
    'not_found'              => 'Registro não encontrado.',
    'permission'              => 'Ooopss! Você não tem permissão para acessar esta opção!',
    'loged'                   => 'Usuário já esta logado!',
    'qty_users'               => 'Limite de usuários ativos foi atingido!',
    'except'                  => 'Exceto: ',
    'val_error'               => 'Erro ao inserir registro.',
    'cb_error'               => 'Barcode Inválido.',
    'dataval_error'               => 'Etiqueta vencida! Não é possível realizar a operação.',
    'end_inativo'               => 'Endereço Inativo.',
    'end_bloq'               => 'Endereço bloqueado para este GRUPO de produto.',
    'end_cap'               => 'Capacidade do endereço foi excedida.',
    'plt_prefixo'               => 'Prefixo de palete inválido.',
    'plt_exists'               => 'Palete já existe no sistema.',
    'plt_not_exists'               => 'Palete não encontrado no sistema.',
    'plt_invalid'               => 'Palete encerrado.',
    'plt_stock'               => 'Palete não possui saldo.',
    'plt_dataval'               => 'Palete possui etiquetas vencidas! Não é possível transferir.',
    'document_number'               => 'Já existe um documento com o número informado.',
    'support_success'               => 'Mensagem enviada! Em breve nossa equipe lhe responderá. ',
    'inv_stock'               => 'Item / Endereço possui Reserva ou Empenho. ',
    'inv_exists'               => 'Item / Endereço já inserido no Documento. ',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'code' => 'Código',
        'description' => 'Descrição',
        'status' => 'Status',
        'margin_div' => 'Margem de Divergência',
        'cost' => 'Custo',
        'product_code' => 'Produto',
        'label_id' => 'Etiqueta',
        'location_code' => 'Endereço',
        'pallet_id' => 'Palete',
        'qty' => 'Quantidade',
        'uom' => 'Unidade',
        'prev_qty' => 'Quantidade Anterior',
        'prev_uom' => 'Unidade Anterior',
        'label_type_code' => 'Tipo de Etiqueta',
        'print_label' => 'Imprime Etiqueta',
        'conf_batch' => 'Confirma Lote',
        'conf_prod_date' => 'Confirma Data de Produção',
        'conf_due_date' => 'Confirma Data de Validade',
        'level' => 'Nível',
        'uom_code' => 'Unidade de Medida',
        'prev_uom_code' => 'Unidade de Medida',
        'create_label' => 'Cria Etiqueta',
        'barcode' => 'Barcode',
        'name' => 'Nome',
        'trading_name' => 'Nome Fantasia',
        'orig_department_code' => 'Departamento Origem',
        'orig_deposit_code' => 'Depósito Origem',
        'dest_department_code' => 'Departamento Destino',
        'dest_deposit_code' => 'Depósito Destino',
        'operation_code'    => 'Operação',
        'document_type_code'  => 'Tipo de Documento',
        'deposit_code'  => 'Depósito',
        'sector_code'  => 'Setor',
        'group_code'  => 'Grupo de Produtos',
        'number'  => 'Número',
        'document_status_id'  => 'Status',
        'customer_code'  => 'Cliente',
        'courier_code'  => 'Transportadora',
        'supplier_code'  => 'Fornecedor',
        'moviment_code'  => 'Movimento',
        'password'  => 'Senha',
        'prev_level'  => 'Nível Anterior',
        'pallet_status_id'  => 'Status',
        'label_status_id'  => 'Status',
        'capacity_un' => 'Capacidade (UN)',
        'dest_location_code' => 'Endereço Destino',
        'orig_location_code' => 'Endereço Origem',
        'aisle' => 'Corredor',
        'column' => 'Coluna',
        'packing_type_code' => 'Embalagem',
        'subgroup_code' => 'SubGrupo',

    ],

];
