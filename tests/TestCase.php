<?php


abstract class TestCase //extends PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        ini_set('memory_limit', '256M');
        putenv('TEST_DB_CONNECTION_SQLITE_DSN=sqlite:cax_test_case_db.sqlite');
    }
}