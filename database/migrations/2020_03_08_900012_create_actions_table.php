<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('type');
            $table->string('note')->nullable();
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('material_id')->nullable();
            $table->unsignedInteger('subscription_id')->nullable();
            $table->unsignedInteger('software_id')->nullable();
            // $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            // $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            // $table->foreign('software_id')->references('id')->on('softwares')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
