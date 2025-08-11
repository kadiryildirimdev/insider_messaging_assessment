<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'))->comment('Tablo ID');
            $table->uuid('ref_user_type')->nullable()->comment('Referans Kullanıcı Türü');
            $table->string('full_name', 100)->comment('Ad Soyad');
            $table->string('phone_number', 14)->comment('Telefon Numarası');
            $table->string('email', 100)->comment('E-mail');
            $table->uuid('created_by')->nullable()->comment('Oluşturan Kullanıcı');
            $table->uuid('updated_by')->nullable()->comment('Güncelleyen Kullanıcı');
            $table->uuid('deleted_by')->nullable()->comment('Silen Kullanıcı');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('active')->default(true)->comment('Kayıt Durumu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
