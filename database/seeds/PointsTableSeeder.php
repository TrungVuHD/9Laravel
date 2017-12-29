<?php

use Illuminate\Database\Seeder;

class PointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = factory(App\Point::class, 5000)->make();

        foreach ($subjects as $subject) {
            repeat:
            try {
                $subject->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $subject = factory(App\Point::class)->make();
                goto repeat;
            }
        }
    }
}
