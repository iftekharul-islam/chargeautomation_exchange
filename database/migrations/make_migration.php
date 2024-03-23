<?php
$_GET=[];
require_once __DIR__ . '/input_validater.php';

if (!$_ENV['APP_DEBUG'] || $_ENV['APP_URL'] != 'http://127.0.0.1/') {
    echo "Action not allowed";
    exit();
}

collectInput(DATABASE);
collectInput(ACTION);
collectInput(TABLE_NAME);

if(isset($_GET[DATABASE['name']],$_GET[ACTION['name']],$_GET[TABLE_NAME['name']]) &&
    !empty($_GET[DATABASE['name']]) && !empty($_GET[ACTION['name']])&& !empty($_GET[TABLE_NAME['name']])
){

    if( in_array($_GET[DATABASE['name']], array_values(DATABASE_ALIAS)) && in_array($_GET[ACTION['name']], array_values(ACTION_ALIAS))) {
        $directory = $_GET[DATABASE['name']] == DATABASE_ALIAS['cax_db'] ? 'cax_db' : 'cax_logs_db';

        if($_GET[ACTION['name']] == ACTION_ALIAS['alter']){
            $file_code = getAlterTableCode($_GET[TABLE_NAME['name']]);
            $file=gmdate("Y_m_d_His").'_alter_'.$_GET[TABLE_NAME['name']].'.php';
        } else {
            $file_code = getCreateTableCode($_GET[TABLE_NAME['name']]);
            $file=gmdate("Y_m_d_His").'_create_'.$_GET[TABLE_NAME['name']].'_table.php';
        }

        $myfile = fopen($directory . '/' . $file, "w") or die("Unable to open file!");
        fwrite($myfile, $file_code);
        fclose($myfile);
        echo 'Migration successfully created.';
    }
}
/*else {
    ?>
    <style>
        .alert {
            border: 1px solid transparent;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            margin-top: 1rem;
            padding: 0.75rem 1.25rem;
            position: relative;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
    <div style="margin: 0 auto; overflow: hidden; width: 80%;">
        <div class="alert alert-danger" role="alert">
            "<b>action</b>" and "<b>table_name</b>" must be required.
        </div>
        <p>
            <b>Note:</b>
            This request need two parameters "action" and "table_name" are required.
            And the third parameter "log_db" is optional that is for log database.
        </p>
        <p>
            1. "action" mean which file you want to generate for create table or alter table. <br>
            2. "table_name" mean which table you want to create or alter. <br>
            3. If you want to generate migration file for log database you need to pass third parameter "log_db" with true or 1 value.
        </p>
        <p>
            <b>Example 1: </b> generate migration for main database the URL like
        <h5>base_url/make_migration?action=create&table_name=xyz_table</h5>
        </p>
        <p>
            <b>Example 2: </b> generate migration for log database the URL like
        <h5>base_url/make_migration?action=create&table_name=xyz_table&log_db=1</h5>
        </p>
    </div>
    <?php
}*/
?>