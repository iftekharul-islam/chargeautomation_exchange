<?php
require_once __DIR__ . '/../../../const/pms_endpoints_const.php';
require_once __DIR__ . '/../../../system/cax_request_keys.php';
require_once __DIR__ . '/../../../system/cax_validation_rule_keys.php';

return [
    'get_booking' => [
        REQUEST_URL_KEY => 'calendar/reservations/{uuid}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [
            'include' => 'guest'
        ],
        INPUT_VALIDATION_RULES => [
            RESERVATION_PMS_RESERVATION_ID => [
                INPUT_NAME => RESERVATION_PMS_RESERVATION_ID,
                RULES => [NOT_EMPTY],
                /*RULES => [
                    NOT_EMPTY => [],
                ]*/
            ],
        ],
    ],

    'get_booking_list' => [
        REQUEST_URL_KEY => 'calendar/reservations',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [
            'include' => 'guest',
            'date_query' => 'checkin'
        ],
        INPUT_VALIDATION_RULES => [
            RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => [
                INPUT_NAME => RESERVATION_HOTEL_REFERENCE_HOTEL_CODE,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
                /*RULES => [
                    NOT_EMPTY => [],
                    SHOULD_NUMERIC => [],
                ]*/
            ],
        ],
    ],

    'get_property' => [
        REQUEST_URL_KEY => 'properties/{property_id}',
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
                /*RULES => [
                    NOT_EMPTY => [],
                    SHOULD_NUMERIC => [],
                ]*/
            ],
        ],
    ],

    'get_property_list' => [
        REQUEST_URL_KEY => 'properties',
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