<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultDescription = 'Esta é a descrição que deve ser apresentada em todas as tarefas criadas de maneira automática cá no sistema TASK-GEST.';
        
        DB::table('tasks')->insert([
            [
                'title' => 'Estudar IA + Machine Learning',
                'description' => $defaultDescription,
                'user_id' => Arr::random([1, 2, 3, 4]),
                'status_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Comprar a comida de casa',
                'description' => $defaultDescription,
                'user_id' => Arr::random([1, 2, 3, 4]),
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pintar o quarto ou usar papel de parede',
                'description' => $defaultDescription,
                'user_id' => Arr::random([1, 2, 3, 4]),
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Comprar Monitor',
                'description' => $defaultDescription,
                'user_id' => Arr::random([1, 2, 3, 4]),
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Estudar Algoritmos e Estrutura de Dados',
                'description' => $defaultDescription,
                'user_id' => Arr::random([1, 2, 3, 4]),
                'status_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Celebrar o Aniversário Fora',
                'description' => $defaultDescription,
                'user_id' => Arr::random([1, 2, 3, 4]),
                'status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Começar a trabalhar na Exata TECH',
                'description' => $defaultDescription,
                'user_id' => Arr::random([1, 2, 3, 4]),
                'status_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
