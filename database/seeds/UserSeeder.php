<?php

use App\Trainer;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'Orlando',
            'surname' => 'Padrón',
            'email' => 'orlando@prueba.com',
            'password' => Hash::make("12345678"),
            'isTrainer' => true,
            'user_image' => 'default_avatar.jpg',
        ]);
        Trainer::create([
            'user_id' => $user->id,
        ]);
    }
}
