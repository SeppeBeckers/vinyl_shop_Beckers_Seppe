<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('genre_id');    // use SAME SIZE as id: unsignedInteger() creates an error!
            $table->string('artist');
            $table->string('artist_mbid', 36)->nullable();
            $table->string('title');
            $table->string('title_mbid', 36)->nullable();
            $table->string('cover')->nullable();
            $table->float('price', 5, 2)->default(19.99);
            $table->unsignedInteger('stock')->default(1);
            $table->timestamps();

            // Foreign key relation
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade')->onUpdate('cascade');
        });
// Insert some genres
        DB::table('genres')->insert(
            [
                ['name' => 'pop/rock',      'created_at' => now()],
                ['name' => 'punk',          'created_at' => now()],
                ['name' => 'industrial',    'created_at' => now()],
                ['name' => 'hardrock',      'created_at' => now()],
                ['name' => 'new wave',      'created_at' => now()],
                ['name' => 'dance',         'created_at' => now()],
                ['name' => 'reggae',        'created_at' => now()],
                ['name' => 'jazz',          'created_at' => now()],
                ['name' => 'dubstep',       'created_at' => now()],
                ['name' => 'blues',         'created_at' => now()],
                ['name' => 'indie rock',    'created_at' => now()],
                ['name' => 'noise',         'created_at' => now()],
                ['name' => 'electro',       'created_at' => now()],
                ['name' => 'techno',        'created_at' => now()],
                ['name' => 'folk',          'created_at' => now()],
                ['name' => 'hip hop',       'created_at' => now()],
                ['name' => 'soul',          'created_at' => now()],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
