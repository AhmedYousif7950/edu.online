<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        \App\Models\Rank::create([
            'name' => 'Admin',
            'created_at'    =>  now(),
            'updated_at'    =>  now(),
        ]);
        \App\Models\Rank::create([
            'name'  =>  'Teacher',
            'created_at'    => now(),
            'updated_at'    => now()
        ]);
        \App\Models\Rank::create([
            'name'  =>  'Student',
            'created_at'    => now(),
            'updated_at'    =>  now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranks');
    }
}
