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
        // // Filling out the fields on our own
        // DB::table('events')->insert([
        //     'name'        => str_random(10),
        //     'description' => str_random(100),
        //     'venue'       => str_random(20),
        //     'start_date'  => Carbon::now()->addDays(5),
        //     'created_at'  => Carbon::now(),
        //     'updated_at'  => Carbon::now()
        // ]);


        // Using model factory
        factory(App\Event::class)->make()->save();
    }
}
