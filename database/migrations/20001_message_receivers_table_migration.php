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
        Schema::create('message_receivers', static function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'))->comment('Tablo ID');
            $table->uuid('transaction_id')->nullable()->comment('İşlem ID');
            $table->uuid('ref_message')->nullable()->comment('Referans Mesaj');
            $table->uuid('ref_user')->nullable()->comment('Referans Kullanıcı');
            $table->string('phone_number', 14)->comment('Telefon Numarası');
            $table->dateTime('sent_at')->nullable()->comment('Gönderim Zamanı');
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
        //
    }
};
