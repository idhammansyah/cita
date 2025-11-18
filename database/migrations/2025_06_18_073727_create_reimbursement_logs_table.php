<?php
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
        Schema::create('reimbursement_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reimbursement_id'); // ID dari reimbursement_employee
            $table->unsignedBigInteger('user_id'); // ID user yang melakukan aksi
            $table->string('action'); // pengajuan, update, approve, reject
            $table->text('description')->nullable(); // deskripsi log
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursement_logs');
    }
};
