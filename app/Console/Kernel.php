<?php

namespace App\Console;

use App\User;
use App\Athlete;
use App\Invoice;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            //Create new invoice on invoices' table. 
            $users = User::where('account_activated', '1')->where('isTrainer', '0')->get();

            foreach ($users as $user) {
                $athlete = $user->athlete;
                Invoice::create([
                    'athlete_id' => $athlete->id,
                    'date' => $athlete->payment_date,
                    'subscription_title' => 'Entrenamiento básico para ' . $user->name,
                    'active_month' => strval(date('01/m/Y')) . ' - ' . strval(date('t/m/Y')),
                    'price' => 30.0,
                    'isPaid' => $athlete->monthPaid == 1 ? '1' : '0',
                ]);
                $athlete->monthPaid = 0;
                $athlete->payment_date = null;
                $athlete->save();
            }
        })->monthlyOn(1);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
