<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', callback: function (Blueprint $table) {
            $table->id();

            // MetaFilter-specific fields
            $table->integer('legacy_id')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('salt');
            $table->string('hashed_password');
            $table->string('state');

            // Default Laravel fields
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->date('birthdate')->nullable();
            $table->boolean('birthdate_year_only')->default(true);
            $table->string('gender')->nullable();
            $table->string('pronouns')->nullable();
            $table->string('relationship_status')->nullable();
            $table->longText('blurb')->nullable();
            $table->longText('blurb_max')->nullable();

            $table->string('salt')->unique();
            $table->string('password');
            $table->string('hashed_password')->unique();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('use_mefi_mail')->default(false);
            $table->string('paypal_email')->nullable();

            $table->string('homepage_url')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('location')->nullable();
            $table->integer('nearby')->nullable();
            $table->integer('regional')->nullable();
            $table->boolean('show_coordinates')->default(false);

            $table->boolean('agrees_to_terms')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_banned')->default(false);
            $table->boolean('show_donate')->default(false);
            $table->boolean('show_share_links')->default(false);

            // Project-specific fields
            $table->string('user_state');

            // Laravel fields
            $table->rememberToken();

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
