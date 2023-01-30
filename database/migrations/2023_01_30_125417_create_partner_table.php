<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public const TABLE_NAME = 'partner';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->id();
            $table->string('company_name', 100)->nullable();
            $table->string('company_ico', 50)->nullable();
            $table->string('company_ic_dph')->nullable();
            $table->string('company_dic', 50)->nullable();
            $table->string('file_mark', 200)->nullable();
            $table->string('company_address', 100)->nullable();
            $table->string('company_email', 70)->nullable();
            $table->string('company_contact_person', 70)->nullable();
            $table->string('company_phone', 30)->nullable();
            $table->boolean('is_dph_payer')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
