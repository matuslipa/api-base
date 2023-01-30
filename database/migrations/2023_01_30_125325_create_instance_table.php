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
        Schema::create(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->id();
            $table->string('name', 50);
            $table->string('identification', 50);
            $table->string('domain', 50);
            $table->string('primary_color', 7);
            $table->string('secondary_color', 7);
            $table->string('button_color', 7);
            $table->string('text_color', 7);
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
