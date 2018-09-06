<?php

use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    return [
        'company_id' => 1,
        'number' => randomNumber(6),
        'emision_date' => date('Y-m-d H:i:s'),
        'document_type_code' => 'OP',
        'document_status_id' => '0',
        'supplier_code' => function () {
            return factory(App\Supplier::class)->create()->code;
        },
    ];
});
