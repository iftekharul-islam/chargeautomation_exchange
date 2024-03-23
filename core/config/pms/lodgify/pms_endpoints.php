<?php
require_once __DIR__ . '/../../../const/pms_endpoints_const.php';
require_once __DIR__ . '/../../../system/cax_request_keys.php';
require_once __DIR__ . '/../../../system/cax_validation_rule_keys.php';

return [
    'get_booking' => [
        REQUEST_URL_KEY => 'v1/reservation/booking/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => null,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            RESERVATION_PMS_RESERVATION_ID => [
                INPUT_NAME => RESERVATION_PMS_RESERVATION_ID,
                RULES => NOT_EMPTY.'|'.SHOULD_NUMERIC.'|'.NOT_SPECIAL_CHARACTERS,
            ],
        ],
    ],
    
    'get_booking_list' => [
        REQUEST_URL_KEY => 'v1/reservation',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => null,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [],
    ],
    
    'get_property' => [
        REQUEST_URL_KEY => 'v2/properties/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => null,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            PROPERTY_HOTEL_CODE => [
                INPUT_NAME => PROPERTY_HOTEL_CODE,
                RULES => NOT_EMPTY.'|'.SHOULD_NUMERIC.'|'.NOT_SPECIAL_CHARACTERS,
            ],
        ],
    ],
    
    'get_property_list' => [
        REQUEST_URL_KEY => 'v2/properties',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => null,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [],
    ],

    'get_unit' => [
        REQUEST_URL_KEY => 'v1/properties/{id}/rooms/{rid}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => null,
        PMS_REQUEST_MAPPER_FILE => UNIT,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            PROPERTY_HOTEL_CODE => [
                INPUT_NAME => PROPERTY_HOTEL_CODE,
                RULES => NOT_EMPTY.'|'.SHOULD_NUMERIC.'|'.NOT_SPECIAL_CHARACTERS,
            ],
            PMS_ROOM_CODE => [
                INPUT_NAME => PMS_ROOM_CODE,
                RULES => NOT_EMPTY.'|'.SHOULD_NUMERIC.'|'.NOT_SPECIAL_CHARACTERS,
            ],
        ],
    ],
];

?>