<?php
require_once __DIR__ . '/input_consts.php';

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
}

function validateInput($input, $rule, $value)
{
    switch ($rule) {
        case 'NotEmpty' :
            $flag = !empty($input);
            break;
        case 'NotSpecialCharacters' :
            $flag = preg_match("/^[a-zA-Z0-9_' ]+$/", $input);
            break;
        case 'InArray' :
            $flag = in_array($input, array_values($value['allowed_values']));
            break;
        case 'PMSUnique' :
            $flag = checkPMSExist($input);
            break;
        default:
            $flag = true;
            break;
    }

    return $flag;
}

function checkPMSExist($input)
{
    $flag = true;
    $pms_name = str_replace(' ', '_', $input);
    $config_dir = CONFIG_PATH . $pms_name;
    $system_dir = SYSTEM_PATH . $pms_name;

    if ((file_exists($config_dir) && is_dir($config_dir)) || (file_exists($system_dir) && is_dir($system_dir))) {
        $flag = false;
    }
    return $flag;
}

function getFileContent($pms_name, $file_path)
{
    return str_replace($pms_name, $pms_name, file_get_contents($file_path));
}

function CreateFile($path, $code)
{
    $myfile = fopen($path, "w") or die("Unable to open file!");
    fwrite($myfile, $code);
    fclose($myfile);
}

?>