<?php

/**
 * Database Migration Runner
 *
 * Usage: php database/migrate.php
 */

require_once __DIR__ . '/../api/core/Database.php';

use App\Core\Database;

try {
    $db = Database::getConnection();

    echo "🚀 Starting migrations...\n\n";

    // Migrations klasöründeki tüm SQL dosyalarını çalıştır
    $migrationsPath = __DIR__ . '/migrations';
    $migrationFiles = glob($migrationsPath . '/*.sql');
    sort($migrationFiles);

    foreach ($migrationFiles as $file) {
        $filename = basename($file);
        echo "📄 Running migration: {$filename}\n";

        $sql = file_get_contents($file);

        // Çoklu SQL ifadelerini ayır ve çalıştır
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            fn($stmt) => !empty($stmt)
        );

        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $db->exec($statement);
            }
        }

        echo "   ✅ Completed\n";
    }

    echo "\n✨ All migrations completed successfully!\n\n";

    // Seed data
    echo "🌱 Running seed data...\n\n";

    $seedsPath = __DIR__ . '/seeds';
    $seedFiles = glob($seedsPath . '/*.sql');
    sort($seedFiles);

    foreach ($seedFiles as $file) {
        $filename = basename($file);
        echo "📄 Running seed: {$filename}\n";

        $sql = file_get_contents($file);

        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            fn($stmt) => !empty($stmt)
        );

        foreach ($statements as $statement) {
            if (!empty($statement)) {
                try {
                    $db->exec($statement);
                } catch (PDOException $e) {
                    // Duplicate entry errors'ı ignore et (seed data tekrar çalıştırılabilir)
                    if ($e->getCode() != 23000) {
                        throw $e;
                    }
                }
            }
        }

        echo "   ✅ Completed\n";
    }

    echo "\n✨ All seeds completed successfully!\n";
    echo "🎉 Database setup complete!\n";

} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
