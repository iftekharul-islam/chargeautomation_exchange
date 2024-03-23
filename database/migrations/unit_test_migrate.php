<?php
/**
 * This file is to create tables for unitTest Sqlite
 */
require_once __DIR__ . '/input_validater.php';

sendLogToSlack('Migrate file successfully run');

//$dictionaries = ['cax_logs_db', 'cax_db'];
foreach (DB_MIGRATION_DIRECTORIES as $dictionary) {
    //$schema_files = glob($dictionary . '/*.php');
    $folder = __DIR__ . '/' . $dictionary;
    $files = scandir($folder);
    $schema_files = preg_grep('/\.php$/', $files);
    foreach ($schema_files as $file) {

        if (str_contains($file, '_alter_')) {
            sendLogToSlack('TestCase Alter Migrations not Implemented yet.'); //TODO
            continue;
        }

        $schema_string = file_get_contents($folder . '/' . $file);
        $schema_string = str_replace('<?php', '', $schema_string);
        $schema_string = str_replace('?>', '', $schema_string);
        $schema_string = str_replace('"', '', $schema_string);
        if ($schema_string !== FALSE) {
            updateDatabase($dictionary, $file, $schema_string);
        }
    }
}

function updateDatabase($dictionary, $file, $schema)
{
    $connection = getDatabaseConnection($dictionary);
    $migrations = checkTableExist($connection, 'migrations');

    if ($migrations) {
        $check_table_exist = $connection->prepare("SELECT `id` FROM `migrations` WHERE `migration`='{$file}'");
        $check_table_exist->execute();
        if ($check_table_exist->rowCount() == 0) {
            createTable($connection, $schema, $file);
        }
    } else {
        $migrations_schema = file_get_contents(__DIR__ . '/' . "migrations.txt");
        createTable($connection, $migrations_schema, "migrations.txt");
        createTable($connection, $schema, $file);
    }
    $connection = null;
}

function createTable($connection, $schema, $file_name)
{
    try {

        //    id INTEGER PRIMARY KEY,
        $schema = preg_replace('/VARCHAR\(\d+\)/i', 'TEXT', trim($schema));
        $schema = str_replace('id int NOT NULL AUTO_INCREMENT', 'id INTEGER PRIMARY KEY', $schema);
        $schema = str_replace('TINYINT', 'INTEGER', $schema);
        $schema = str_replace('int', 'INTEGER', $schema);
        $schema = str_replace('ENGINE=InnoDB DEFAULT CHARSET=utf8mb4', '', $schema);
        $schema = preg_replace('/[, ]*PRIMARY KEY [(]id[)]/', '', $schema);
        $schema = preg_replace("/\s*FOREIGN KEY\s*\(\s*\w+\s*\)\s*REFERENCES\s*\w+\s*\(\s*\w+\s*\)\s*ON DELETE CASCADE\s*,?/", '', $schema);
        $schema = str_replace('updated_at TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP', '', $schema);
        $schema = preg_replace('/,\s*\)|,$/', ')', $schema);
        $schema = preg_replace('/,\s*\)/', ')', $schema);
        $schema = preg_replace('/,\s*\)/', ')', $schema);



        $pdo_statement = $connection->prepare($schema);
        $result = $pdo_statement->execute();
        if ($file_name != 'migrations.txt' && $result) {
            insertMigration($connection, $file_name);
        }
    } catch (Exception $e) {
        echo $schema;
        echo $e->getTraceAsString();
        echo "Error: Table creation failed: " . $e->getMessage() . PHP_EOL;
        die('Here1');
        return FALSE;
    }
    return $pdo_statement !== FALSE;
}

function insertMigration($connection, $file_name)
{
    try {
        $pdo_statement = $connection->prepare("INSERT INTO `migrations`(`migration`) VALUES ('{$file_name}')");
        $pdo_statement->execute();
        echo "Migration " . $file_name . " successfully migrated.\n";
    } catch (Exception $e) {
        echo "Error: Migration " . $file_name . " failed: " . $e->getMessage() . PHP_EOL;
        return FALSE;
    }
    return $pdo_statement !== FALSE;
}

?>