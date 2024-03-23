<?php
require_once __DIR__ . '/../../../const/pms_endpoints_const.php';
require_once __DIR__ . '/../../../system/cax_request_keys.php';
require_once __DIR__ . '/../../../system/cax_validation_rule_keys.php';

return [
    'get_booking' => [
        REQUEST_URL_KEY => 'reservations/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            RESERVATION_PMS_RESERVATION_ID => [
                INPUT_NAME => RESERVATION_PMS_RESERVATION_ID,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_booking_list' => [
        REQUEST_URL_KEY => 'reservations',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => [
                INPUT_NAME => RESERVATION_HOTEL_REFERENCE_HOTEL_CODE,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_property' => [
        REQUEST_URL_KEY => 'listings/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [
            'include_related_objects' => 1
        ],
        INPUT_VALIDATION_RULES => [
            PROPERTY_HOTEL_CODE => [
                INPUT_NAME => PROPERTY_HOTEL_CODE,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_property_list' => [
        REQUEST_URL_KEY => 'listings',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [],
    ],

    'get_child_property_list' => [
        REQUEST_URL_KEY => 'listings/children/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            PROPERTY_HOTEL_CODE => [
                INPUT_NAME => PROPERTY_HOTEL_CODE,
                RULES => NOT_EMPTY.'|'.SHOULD_NUMERIC.'|'.NOT_SPECIAL_CHARACTERS,
            ],
        ],
    ],

    'get_guest' => [
        REQUEST_URL_KEY => 'guests/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => GUEST,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            RESERVATION_GUEST_ID => [
                INPUT_NAME => RESERVATION_GUEST_ID,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    /*'get_guest_list' => [
        REQUEST_URL_KEY => 'guests',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => GUEST,
        EXTRA_DATA_KEY => [],
    ],*/
];

?>