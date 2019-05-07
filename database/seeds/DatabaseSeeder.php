<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Event;
use App\Ticket;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $users = factory(User::class, 20)->create();
        $events = factory(Event::class, 20)->create();

        User::create([
            'name' => 'Gene Carlo Ramirez',
            'email' => 'gram031998@gmail.com',
            'password' => bcrypt('123'),
        ]);


    }
}
