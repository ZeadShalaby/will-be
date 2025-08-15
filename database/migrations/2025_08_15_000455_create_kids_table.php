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
       Schema::create('kids', function (Blueprint $table) {
        $table->id();
        $table->string('full_name'); // اسم الطفل رباعي
        $table->date('birth_date'); // تاريخ الميلاد
        $table->string('mother_name'); // اسم الأم
        $table->string('mother_phone')->nullable(); // رقم الأم واتس
        $table->string('father_name'); // اسم الأب
        $table->string('father_phone')->nullable(); // رقم الأب واتس
        $table->string('guardian_name')->nullable(); // اسم ولي الأمر
        $table->string('guardian_phone')->nullable(); // رقم ولي الأمر واتس
        $table->string('guardian_relation')->nullable(); // صلة القرابة
        $table->enum('transport_method', ['bus', 'other']); // الوصول باص أو غيره
        $table->string('how_did_you_know')->nullable(); // كيف تعرفت علينا
        $table->enum('status', ['active', 'inactive','pending'])->default('pending'); // حالة الطفل
        $table->text('notes')->nullable(); // ملاحظات إضافية
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kids');
    }
};
