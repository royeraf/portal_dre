<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql' && Schema::hasTable('directorio')) {
            // The public portal intentionally does not expose DNI values.
            // NULL preserves that absence and remains compatible with the
            // legacy unique index (MySQL permits multiple NULL values).
            DB::statement('ALTER TABLE directorio MODIFY dni VARCHAR(8) NULL');
        }
    }

    public function down(): void
    {
        // Do not restore NOT NULL: doing so would require fabricating private
        // identifiers for records collected from the public portal.
    }
};
