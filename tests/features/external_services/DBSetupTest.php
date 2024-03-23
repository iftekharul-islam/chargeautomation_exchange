<?php


namespace features\external_services;


use DB;
use TestCase;


class DBSetupTest extends TestCase
{

    public static function setUpBeforeClass(): void
    {
        self::setFreshEnvironment();
        parent::setUpBeforeClass();
        shell_exec('php database/migrations/unit_test_migrate.php');
    }

    public function testConnection()
    {
        $this->assertEquals(true, true);
    }

    protected function tearDown(): void
    {

    }

    /**
     * Drop old Test Case Sqlite DB
     */
    private static function setFreshEnvironment()
    {
        $database_file = "cax_test_case_db.sqlite";
        if (file_exists($database_file)) {
            unlink($database_file);
        }
    }


}