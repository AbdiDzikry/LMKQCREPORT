<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('problem_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('report_date');
            $table->enum('section', ['2W', '4W']);
            $table->string('comp_name_2w')->nullable();
            $table->string('part_number');
            $table->string('part_name');
            $table->enum('customer', ['AHM', 'ADM', 'HMMI', 'HPM', 'MKM']);
            $table->string('line_problem');
            $table->enum('category', ['Single Part', 'Sub Assy', 'Finishing']);
            $table->integer('quantity');
            $table->enum('problem_status', ['baru', 'berulang']);
            $table->string('vendor');
            $table->string('type');
            $table->enum('problem_type', ['visual', 'dimensi', 'kelengkapan']);
            $table->text('detail');
            $table->string('pic_qc');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem_reports');
    }
};
