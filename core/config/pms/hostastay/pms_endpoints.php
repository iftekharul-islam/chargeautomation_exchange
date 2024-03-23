<?php
require_once __DIR__ . '/../../../const/pms_endpoints_const.php';
require_once __DIR__ . '/../../../system/cax_request_keys.php';
require_once __DIR__ . '/../../../system/cax_validation_rule_keys.php';

return [

    'update_booking' => [
        REQUEST_URL_KEY => '/reservation/{code}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => PUT,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [],
    ],

    'get_booking' => [
        REQUEST_URL_KEY => '/reservation/{code}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            RESERVATION_PMS_RESERVATION_ID => [
                INPUT_NAME => RESERVATION_PMS_RESERVATION_ID,
                RULES => [NOT_EMPTY],
            ],
        ],
    ],

    'get_booking_list' => [
        REQUEST_URL_KEY => '/reservation',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [
            'type' => 'unit',
            'status' => 'all',
        ],
        INPUT_VALIDATION_RULES => [
            RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => [
                INPUT_NAME => RESERVATION_HOTEL_REFERENCE_HOTEL_CODE,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
            RESERVATION_START_DATE => [
                INPUT_NAME => RESERVATION_START_DATE,
                RULES => NOT_EMPTY,
            ],
        ],
    ],

    'get_property' => [
        REQUEST_URL_KEY => '/unit/{unit_id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            PROPERTY_HOTEL_CODE => [
                INPUT_NAME => PROPERTY_HOTEL_CODE,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_property_list' => [
        REQUEST_URL_KEY => '/unit',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [],
    ],
];

?>