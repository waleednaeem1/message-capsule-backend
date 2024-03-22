<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageCapsulesTable extends Migration
{
    public function up()
    {
        Schema::create('message_capsules', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->timestamp('scheduled_opening_time')->nullable();
            $table->boolean('opened')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('message_capsules');
    }
}
