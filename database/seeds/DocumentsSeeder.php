<?php

use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->insert([
            'company_id' => 1,
            'number' => rand(12233, 153568),
            'document_type_code' => 'OPR',
            'document_status_id' => rand(0,9),
            'customer_id' => rand(0,9),
            'emission_date' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
