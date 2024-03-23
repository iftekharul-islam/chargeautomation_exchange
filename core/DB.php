<?php

class DB
{
    private static PDO $connection;
    private static PDO $log_db_connection;

    /**
     * @return PDO|string
     */
    public static function getConnection()
    {
        try {

            if (php_sapi_name() == 'cli') {
                return self::getTestCaseDBConnection(); //TestCase SQLite Connection

            } elseif (empty(self::$connection)) {

                $server = $_ENV['DB_CONNECTION'] . ":host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'];
                self::setConnection(new PDO($server, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']));

            }

            return self::$connection;

        } catch (PDOException $PDOException) {
            sendLogToSlack(
                "There is some problem in connection.",
                [
                    __FILE__,
                    __FUNCTION__,
                    $PDOException->getMessage(),
                    $PDOException->getTraceAsString()
                ]
            );

            if ($_ENV['APP_DEBUG'] || $_ENV['APP_URL'] != 'http://127.0.0.1/') {
                die($PDOException->getMessage());
            }

            die("There is some problem in connection. __CODE__:DB_Connection");
        }
    }

    public static function getLogDatabaseConnection()
    {
        try {

            if (php_sapi_name() == 'cli') {
                return self::getTestCaseDBConnection(); //TestCase Sqlite Connection

            } elseif (empty(self::$log_db_connection)) {
                $server = $_ENV['DB_CONNECTION'] . ":host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['LOG_DB_DATABASE'];
                self::setLogDbConnection(new PDO($server, $_ENV['LOG_DB_USERNAME'], $_ENV['LOG_DB_PASSWORD']));
            }

            return self::$log_db_connection;

        } catch (PDOException $e) {
            sendLogToSlack(
                "There is some problem in connection.",
                [
                    __FILE__,
                    __FUNCTION__,
                    $e->getMessage(),
                    $e->getTraceAsString()
                ]
            );

            die("There is some problem in connection. __CODE__:executeLogConnection");
        }
    }

    public static function executeQueryForLog($statement, $execute_parameters = null)
    {
        try {
            $pdoStatement = DB::getLogDatabaseConnection()->prepare($statement);
            $pdoStatement->execute($execute_parameters);
            return $pdoStatement;
        } catch (PDOException $e) {
            sendLogToSlack(
                "There is some problem in connection.",
                [
                    __FILE__,
                    __FUNCTION__,
                    $statement,
                    $execute_parameters,
                    $e->getMessage(),
                    $e->getTraceAsString()
                ]
            );

            die("There is some problem in connection. __CODE__:executeLogStatement");
        }
    }

    /**
     * @param $pdoStatement
     * @param null $execute_parameters
     * @return false|PDOStatement
     */
    public static function executeStatement($statement, $execute_parameters = null)
    {
        try {
            $pdoStatement = DB::getConnection()->prepare($statement);
            $pdoStatement->execute($execute_parameters);
            saveQueryLog($statement, $execute_parameters);
            return $pdoStatement;
        } catch (PDOException $e) {
            sendLogToSlack(
                "There is some problem in connection.",
                [
                    __FILE__,
                    __FUNCTION__,
                    $statement,
                    $execute_parameters,
                    $e->getMessage(),
                    $e->getTraceAsString()
                ]
            );

            if ($_ENV['APP_DEBUG'] || $_ENV['APP_URL'] != 'http://127.0.0.1/') {
                die($e->getMessage());
            }

            die("There is some problem in connection. __CODE__:executeStatement");
        }
    }

    /**
     * @param mixed $connection
     */
    public static function setConnection($connection): void
    {
        self::$connection = $connection;
    }

    /**
     * @param mixed $log_db_connection
     */
    public static function setLogDbConnection($log_db_connection): void
    {
        self::$log_db_connection = $log_db_connection;
    }

    /**
     * TestCase DB connection move to SQLite
     */
    public static function getTestCaseDBConnection(): PDO
    {
        if (empty(getenv('TEST_DB_CONNECTION_SQLITE_DSN')) || php_sapi_name() != 'cli') {
            die('TEST_DB_CONNECTION_SQLITE_DSN not configured');
        }

        $pdo = new \PDO(getenv('TEST_DB_CONNECTION_SQLITE_DSN'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}