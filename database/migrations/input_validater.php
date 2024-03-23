<?php
require_once __DIR__ . '/input_consts.php';

function getDatabaseConnection($dictionary)
{
    try {

        if (!empty(getenv('TEST_DB_CONNECTION_SQLITE_DSN'))){
            return DB::getTestCaseDBConnection(); //IF TestCase Procedures Set Migration Connection to SQLITE DSN

        } else if ($dictionary == "cax_db") {
            $server = $_ENV['DB_CONNECTION'] . ":host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'];
            return new PDO($server, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
        } elseif ($dictionary == "cax_logs_db") {
            $server = $_ENV['DB_CONNECTION'] . ":host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['LOG_DB_DATABASE'];
            return new PDO($server, $_ENV['LOG_DB_USERNAME'], $_ENV['LOG_DB_PASSWORD']);
        }

    } catch (Exception $e) {
        echo "Error: Connection to database failed: " . $e->getMessage() . PHP_EOL;
        return FALSE;
    }
}

function checkTableExist($connection, $table)
{
    try {
        $result = $connection->prepare("SELECT 1 FROM `" . $table . "` LIMIT 1");
        $result->execute();
    } catch (Exception $e) {
        //echo "Warning: Checking table existence failed: " . $e->getMessage() . PHP_EOL;
        echo "Could not verify if table exist or not.";
        return FALSE;
    }
    return $result !== FALSE;
}

function alterTableValidation(){
    $flipped_database_alias = array_flip(DATABASE_ALIAS);
    $connection = getDatabaseConnection($flipped_database_alias[$_GET[DATABASE['name']]]);
    if(!checkTableExist($connection, $_GET[TABLE_NAME['name']])){
        echo $_GET[TABLE_NAME['name']].' not exist in database. ';
        collectInput(TABLE_NAME);
    }
}

function collectInput($input_const)
{
    global $_GET;
    echo $input_const['label'];
    $_GET[$input_const['name']] = $input = trim(fgets(STDIN));
    runValidation($input, $input_const);
}

function runValidation($input, $input_const)
{
    $flag = true;
    foreach ($input_const['rules'] as $rule => $value) {
        if (!$flag = validateInput($input, $rule, $value)) {
            echo $value['message'];
            break;
        }
    }

    if (!$flag) {
        collectInput($input_const);
    }

    if(array_key_exists(ACTION['name'], $_GET) && array_key_exists(TABLE_NAME['name'], $_GET)
        && $_GET[ACTION['name']]==ACTION_ALIAS['alter'] && $flag) {
        alterTableValidation();
    }
}

function validateInput($input, $rule, $value)
{
    switch ($rule) {
        case 'NotEmpty' :
            $flag = !empty($input);
            break;
        case 'InArray' :
            $flag = in_array($input, array_values($value['allowed_values']));
            break;
        case 'NotSpecialCharacters' :
            $flag = preg_match("/^[a-zA-Z0-9_' ]+$/", $input);
            break;
        default:
            $flag = true;
            break;
    }

    return $flag;
}

function getCreateTableCode($table)
{
    return '<?php
"CREATE TABLE ' . $table . ' (
id int NOT NULL AUTO_INCREMENT,
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
?>';
}

function getAlterTableCode($table)
{
    return '<?php "ALTER TABLE ' . $table . ';" ?>';
}