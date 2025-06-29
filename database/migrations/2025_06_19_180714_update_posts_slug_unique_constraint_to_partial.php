<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop the existing unique constraint on slug
            $table->dropUnique(['slug']);
        });

        // Uses IF(is_published = 1, 1, NULL) so only published records enforce uniqueness.
        DB::statement('CREATE UNIQUE INDEX posts_slug_published_unique ON posts (slug, (IF(is_published = 1, 1, NULL)))');
    }

    public function down(): void
    {
        // Drop the functional unique index
        DB::statement('DROP INDEX posts_slug_published_unique ON posts');

        Schema::table('posts', function (Blueprint $table) {
            // Restore the original unique constraint
            $table->unique('slug');
        });
    }
};
