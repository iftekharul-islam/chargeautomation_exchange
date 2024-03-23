<?php
require_once __DIR__ . '/input_validater.php';
$_GET = [];
collectInput(PMS_NAME);

try {
    $pms_given_name=$_GET[PMS_NAME['name']];
    $pms_name = str_replace(' ', '_', $pms_given_name);
    $config_pms_path = CONFIG_PATH . $pms_name;
    $system_pms_path = SYSTEM_PATH . $pms_name;

    if (mkdir($config_pms_path)) {

        CreateFile($config_pms_path . PMS_BOOKING_SOURCES_FILE,  getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_BOOKING_SOURCES_FILE));
        CreateFile($config_pms_path . PMS_BOOKING_STATUS_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_BOOKING_STATUS_FILE));
        CreateFile($config_pms_path . PMS_MANIFEST_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_MANIFEST_FILE));
        CreateFile($config_pms_path . PMS_ENDPOINT_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_END_POINTS_FILE));

        if (mkdir($config_pms_path . PMS_REQUEST_MAPPER)) {
            CreateFile($config_pms_path . PMS_REQUEST_MAPPER . GUEST_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_REQUEST_MAPPER.GUEST_FILE));
            CreateFile($config_pms_path . PMS_REQUEST_MAPPER . PROPERTY_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_REQUEST_MAPPER.PROPERTY_FILE));
            CreateFile($config_pms_path . PMS_REQUEST_MAPPER . BOOKING_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_REQUEST_MAPPER.BOOKING_FILE));
        }

        if (mkdir($config_pms_path . PMS_RESPONSE_MAPPER)) {
            CreateFile($config_pms_path . PMS_RESPONSE_MAPPER . GUEST_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_RESPONSE_MAPPER.GUEST_FILE));
            CreateFile($config_pms_path . PMS_RESPONSE_MAPPER . PROPERTY_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_RESPONSE_MAPPER.PROPERTY_FILE));
            CreateFile($config_pms_path . PMS_RESPONSE_MAPPER . BOOKING_FILE, getFileContent($pms_name, TEMPLATE_CONFIG_FILE_PATH.PMS_RESPONSE_MAPPER.BOOKING_FILE));
        }
    }

    if(mkdir($system_pms_path)) {
        CreateFile($system_pms_path . EXCEPTION_CODES_CLASS, getFileContent($pms_name, TEMPLATE_SYSTEM_FILE_PATH.EXCEPTION_CODES_CLASS));
        CreateFile($system_pms_path . MAPPER_HELPER, getFileContent($pms_name, TEMPLATE_SYSTEM_FILE_PATH.MAPPER_HELPER));
        CreateFile($system_pms_path . PMS_CLASS, getFileContent($pms_name, TEMPLATE_SYSTEM_FILE_PATH.PMS_CLASS));
        CreateFile($system_pms_path . PMS_HELPER_TRAIT, getFileContent($pms_name, TEMPLATE_SYSTEM_FILE_PATH.PMS_HELPER_TRAIT));
    }

    echo 'PMS skeleton successfully created.';

} catch (Exception $e) {
    echo "Error: Some unexpected error occurred: " . $e->getMessage() . PHP_EOL;
}
?>