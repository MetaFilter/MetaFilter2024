<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // MetaFilter-specific fields
            $table->string('username')->unique();
            $table->string('salt')->unique();
            $table->string('hashed_password')->unique();

            // Default Laravel fields
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // MetaFilter-specific fields
            $table->string('homepage_url')->nullable();
            $table->boolean('agrees_to_terms')->nullable();
            $table->boolean('is_admin')->nullable();
            $table->boolean('show_email')->nullable();
            $table->boolean('use_mefi_mail')->nullable();
            $table->integer('legacy_id')->nullable()->unique();
            $table->longText('blurb')->nullable();
            $table->longText('blurb_max')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('location')->nullable();
            $table->string('gender')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('pronouns')->nullable();

            // Project-specific fields
            $table->string('state');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
};
