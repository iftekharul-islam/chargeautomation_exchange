<?php
require_once __DIR__ . '/../../includes/autoload.php';

if (!$_ENV['APP_DEBUG'] || $_ENV['APP_URL'] != 'http://127.0.0.1/') {
    echo "Action not allowed";
    exit();
}
const CONFIG_PATH = __DIR__ . '/../../config/pms/';
const SYSTEM_PATH = __DIR__ . '/../../system/pms/';

const TEMPLATE_CONFIG_FILE_PATH = __DIR__ . '/template_files/config_files';
const TEMPLATE_SYSTEM_FILE_PATH = __DIR__ . '/template_files/system_files';


const PMS_REQUEST_MAPPER = '/pms_request_mapper';
const PMS_RESPONSE_MAPPER = '/pms_response_mapper';

const PMS_ENDPOINT_FILE = '/pms_endpoints.php';
const PMS_BOOKING_SOURCES_FILE = '/booking_sources.php';
const PMS_BOOKING_STATUS_FILE = '/booking_status.php';
const PMS_MANIFEST_FILE = '/manifest.json';
const PMS_END_POINTS_FILE = '/pms_endpoints.php';

const GUEST_FILE = '/guest.php';
const PROPERTY_FILE = '/property.php';
const BOOKING_FILE = '/reservation.php';

const EXCEPTION_CODES_CLASS = '/ExceptionCodes.php';
const MAPPER_HELPER = '/mapper_helper.php';
const PMS_CLASS = '/PMS.php';
const PMS_HELPER_TRAIT = '/PMS_Helper.php';

const PMS_NAME = [
    'name' => 'pms_name',
    'label' => 'Please Enter PMS Name: ',
    'rules' => [
        'NotEmpty' => ['message' => 'PMS Name must be required. '],
        'NotSpecialCharacters' => ['message' => 'Special character not allowed. '],
        'PMSUnique' => ['message' => 'Given PMS already exist. ']
    ]
];

?>