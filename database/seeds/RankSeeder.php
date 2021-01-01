<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ranks')->delete();

        Rank::create([
            'name' => rand(10),
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);
    }
}
