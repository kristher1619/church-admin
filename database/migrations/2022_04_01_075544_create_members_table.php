<?php

use App\Models\Member;
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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->date('date_of_baptism')->nullable();
            $table->string('baptismal_certificate')->nullable();
            $table->string('photo')->nullable();
            $table->string('membership_status')->nullable();
            $table->text('notes')->nullable();
            $table->string('sex')->nullable();
            $table->dateTime('date_died')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger( 'father_id')->nullable();
            $table->unsignedBigInteger( 'mother_id')->nullable();

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
        Schema::dropIfExists('members');
    }
};
