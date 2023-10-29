<?php

use App\Models\Employee;
use App\Models\Week;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('task_type', ['projects', 'quotes', 'regular', 'trainings', 'unplanned']);
            $table->string('task_name');
            $table->string('task_product')->nullable();
            $table->time('planned_time')->nullable();
            $table->time('actual_time')->nullable();
            $table->date('completion_time')->nullable();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Week::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
