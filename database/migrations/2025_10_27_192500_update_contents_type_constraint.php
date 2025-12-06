<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        if ($this->constraintExists('chk_contents_type')) {
            $this->dropConstraint('chk_contents_type');
        }

        DB::statement('ALTER TABLE `contents` ADD CONSTRAINT `chk_contents_type` CHECK (type IN ("text", "image", "video"))');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        if ($this->constraintExists('chk_contents_type')) {
            $this->dropConstraint('chk_contents_type');
        }

        DB::statement('ALTER TABLE `contents` ADD CONSTRAINT `chk_contents_type` CHECK (type IN ("text", "image"))');
    }

    private function constraintExists(string $constraintName): bool
    {
        $result = DB::select(
            'SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? LIMIT 1',
            ['contents', $constraintName]
        );

        return ! empty($result);
    }

    private function dropConstraint(string $constraintName): void
    {
        $table = 'contents';
        try {
            DB::statement("ALTER TABLE `{$table}` DROP CHECK `{$constraintName}`");
            return;
        } catch (\Throwable $primary) {
            try {
                DB::statement("ALTER TABLE `{$table}` DROP CONSTRAINT `{$constraintName}`");
            } catch (\Throwable $fallback) {
                $message = strtolower($fallback->getMessage() ?? '');
                if (str_contains($message, 'does not exist') || str_contains($message, 'unknown constraint')) {
                    return;
                }
                throw $fallback;
            }
        }
    }
};
