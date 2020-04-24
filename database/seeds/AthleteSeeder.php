<?php

use App\Athlete;
use App\Trainer;
use Illuminate\Database\Seeder;

class AthleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Athlete::class, 20)->create();
    }
}
