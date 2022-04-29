<?php

use App\Models\RestaurantUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(RestaurantUser::TABLE, function (Blueprint $table) {
            $table->foreignId(RestaurantUser::RESTAURANT_ID)->constrained();
            $table->unsignedBigInteger(RestaurantUser::USER_ID)->index();

            $table->unique([RestaurantUser::RESTAURANT_ID, RestaurantUser::USER_ID]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(RestaurantUser::TABLE);
    }
};
