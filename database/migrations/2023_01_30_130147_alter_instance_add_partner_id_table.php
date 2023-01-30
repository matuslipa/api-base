<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public const TABLE_NAME = 'instance';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->foreign('partner_id')
                ->references('id')
                ->on('partner')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->dropForeign(['partner_id']);
            $table->dropColumn('partner_id');
        });
    }
};
