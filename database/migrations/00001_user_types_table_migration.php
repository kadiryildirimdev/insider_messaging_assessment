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
        Schema::create('user_types', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'))->comment('Tablo ID');
            $table->string('code', 5)->comment('Kod');
            $table->string('name', 100)->comment('Ad');
            $table->string('description', 100)->nullable()->comment('Açıklama');
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
        Schema::dropIfExists('user_types');
    }
};
