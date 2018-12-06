<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Always restarted the database
        // App\Event::truncate();

        // Using model factory        
        factory(App\Event::class,5)
            ->create()
            ->each(function($event){              
                $event->save();
            }
        );
    }
}
