<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'adm@adm',
                'password' => Hash::make('1'),
                'telefone' => '1',
                'cpf' => '01',
            ],
            [
                'name' => 'Cliente A',
                'email' => 'a@a',
                'password' => Hash::make('1'),
                'telefone' => '2',
                'cpf' => '02',
            ],
            [
                'name' => 'Cliente B',
                'email' => 'b@b',
                'password' => Hash::make('1'),
                'telefone' => '3',
                'cpf' => '03',
            ],
        ]);

        DB::table('compras')->insert([
            [
                'user_id' => 2,
                'concluida' => false,
                'data_compra' => null,
            ],
            [
                'user_id' => 3,
                'concluida' => false,
                'data_compra' => null,
            ],
        ]);

        DB::table('categorias')->insert([
            [
                'nome' => 'Roupas',
                'descricao' => 'Roupas variadas',
            ],
            [
                'nome' => 'Equipamentos',
                'descricao' => 'Equipamentos esportivos',
            ],
        ]);

        DB::table('produtos')->insert([
            [
                'categoria_id' => '1',
                'nome' => 'Camisa de time',
                'descricao' => 'Camisa de time aleatório',
                'marca' => 'Adidas',
                'cor' => '#000000',
                'preco' => 110.50,
                'peso' => 1,
                'estoque' => 10,
            ],
            [
                'categoria_id' => '2',
                'nome' => 'Bola de futebol',
                'descricao' => 'bola',
                'marca' => 'Adidas',
                'cor' => '#000000',
                'preco' => 50,
                'peso' => 2,
                'estoque' => 5,
            ],
        ]);

        DB::table('promocoes')->insert([
            [
                'nome' => 'Sexta Caotica',
                'descricao' => 'Chaos',
                'data_inicio' => '16/02/24',
                'data_fim' => '17/02/24',
                'percentagem' => 75,
            ],
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
