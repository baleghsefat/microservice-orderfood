<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Restaurant;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Restaurant::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Restaurant::NAME);
            $table->float(Restaurant::LAT, 15, 12)->nullable();
            $table->float(Restaurant::LNG, 15, 12)->nullable();
            $table->string(Restaurant::ADDRESS, 512);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Restaurant::TABLE);
    }
};
