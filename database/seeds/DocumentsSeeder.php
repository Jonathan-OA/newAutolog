<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $suppliers = App\Models\Supplier::all()->pluck('code')->toArray();
        for($i=0;$i<2000;$i++){
            DB::table('documents')->insert([
                'company_id' => 1,
                'number' => $faker->randomNumber(6),
                'document_type_code' => 'OP',
                'document_status_id' => $faker->randomElement([0,1,2]),
                'supplier_code' => $faker->randomElement($suppliers),
                'emission_date' => date("Y-m-d H:i:s"),
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
