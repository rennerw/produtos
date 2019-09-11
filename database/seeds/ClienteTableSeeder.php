<?php

use Illuminate\Database\Seeder;
use Faker\Provider\pt_BR\Person;
use Faker\Generator as Faker;
class ClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run(Faker $faker)
    {
        
        for ($i=0; $i < 5; $i++) { 
            DB::table('clientes')->insert([
                'nome' => $faker->name,
                'cpf' => $faker->cpf(),
                'email' => $faker->email
            ]);
        }
    }
}
