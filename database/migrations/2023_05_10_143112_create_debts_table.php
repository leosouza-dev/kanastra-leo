<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtsTable extends Migration
{
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('government_id');
            $table->string('email');
            $table->integer('debt_id');
            $table->float('debt_amount');
            $table->dateTime('debt_due_date');
            $table->dateTime('paid_at')->nullable();
            $table->float('paid_amount')->nullable();
            $table->string('paid_by')->nullable();
            $table->enum('status', ['OPEN', 'PAID', 'OVERDUE'])->default('OPEN');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debts');
    }
};
