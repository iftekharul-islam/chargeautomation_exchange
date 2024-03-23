<?php
require_once __DIR__ . '/../../../const/pms_endpoints_const.php';
require_once __DIR__ . '/../../../system/cax_request_keys.php';
require_once __DIR__ . '/../../../system/cax_validation_rule_keys.php';

return [
    'get_booking' => [
        REQUEST_URL_KEY => 'bookings/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            RESERVATION_PMS_RESERVATION_ID => [
                INPUT_NAME => RESERVATION_PMS_RESERVATION_ID,
                RULES => [NOT_EMPTY, SHOULD_NUMERIC, NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_booking_list' => [

        REQUEST_URL_KEY => 'bookings',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [
            'include_tags' => 'true',
            'include_guest' => 'true',
            'include_fields' => 'true',
            'include_charges' => 'true',
            'include_door_codes' => 'true',
        ],
        INPUT_VALIDATION_RULES => [
            RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => [
                INPUT_NAME => RESERVATION_HOTEL_REFERENCE_HOTEL_CODE,
                RULES => [NOT_EMPTY, SHOULD_NUMERIC, NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_property' => [
        REQUEST_URL_KEY => 'properties/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            PROPERTY_HOTEL_CODE => [
                INPUT_NAME => PROPERTY_HOTEL_CODE,
                RULES => [NOT_EMPTY, SHOULD_NUMERIC, NOT_SPECIAL_CHARACTERS],
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
    ],

    'get_guest' => [
        REQUEST_URL_KEY => 'guests/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => GUEST,
        EXTRA_DATA_KEY => [
            'include_tags' => 'true',
            'include_fields' => 'true'
        ],
        INPUT_VALIDATION_RULES => [
            RESERVATION_GUEST_ID => [
                INPUT_NAME => RESERVATION_GUEST_ID,
                RULES => [NOT_EMPTY, SHOULD_NUMERIC, NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'add_custom_item_definition' => [
        REQUEST_URL_KEY => 'fielddefinitions',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => POST,
        REQUEST_CONTENT_TYPE => REQUEST_CONTENT_TYPE_FORM_URL_ENCODE,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => CUSTOM_ITEM_DEFINITION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            CUSTOM_ITEM_DEFINITION_CODE => [
                INPUT_NAME => CUSTOM_ITEM_DEFINITION_CODE,
                RULES => [NOT_EMPTY, NOT_SPECIAL_CHARACTERS],
            ],
            CUSTOM_ITEM_DEFINITION_NAME => [
                INPUT_NAME => CUSTOM_ITEM_DEFINITION_NAME,
                RULES => [NOT_EMPTY, NOT_SPECIAL_CHARACTERS],
            ],
            CUSTOM_ITEM_DEFINITION_TYPE => [
                INPUT_NAME => CUSTOM_ITEM_DEFINITION_TYPE,
                RULES => [NOT_EMPTY],
            ],
            CAX_REQUEST_NAME_KEY => [
                INPUT_NAME => CAX_REQUEST_NAME_KEY,
                RULES => [NOT_EMPTY], //TODO::
            ]
        ],
    ],

    'get_custom_item_definition' => [
        REQUEST_URL_KEY => 'fielddefinitions/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => CUSTOM_ITEM_DEFINITION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            CUSTOM_ITEM_DEFINITION_ID => [
                INPUT_NAME => CUSTOM_ITEM_DEFINITION_ID,
                RULES => [NOT_EMPTY, NOT_SPECIAL_CHARACTERS],
            ],
            CAX_REQUEST_NAME_KEY => [
                INPUT_NAME => CAX_REQUEST_NAME_KEY,
                RULES => [NOT_EMPTY], //TODO::
            ]
        ],
    ],

    'get_custom_item_definition_list' => [
        REQUEST_URL_KEY => 'fielddefinitions',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => CUSTOM_ITEM_DEFINITION,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            CAX_REQUEST_NAME_KEY => [
                INPUT_NAME => CAX_REQUEST_NAME_KEY,
                RULES => [NOT_EMPTY], //TODO::
            ]
        ],
    ],


    'add_custom_item' => [
        REQUEST_URL_KEY => 'fields',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => POST,
        REQUEST_CONTENT_TYPE => REQUEST_CONTENT_TYPE_APPLICATION_JSON,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => CUSTOM_ITEM,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            CUSTOM_ITEM_VALUE => [
                INPUT_NAME => CUSTOM_ITEM_VALUE,
                RULES => [NOT_EMPTY],
            ],
            CUSTOM_ITEM_ENTITY_ID => [
                INPUT_NAME => CUSTOM_ITEM_ENTITY_ID,
                RULES => [NOT_EMPTY, SHOULD_NUMERIC],
            ],
            CUSTOM_ITEM_VALUE_DEFINITION_ID => [
                INPUT_NAME => CUSTOM_ITEM_VALUE_DEFINITION_ID,
                RULES => [NOT_EMPTY, SHOULD_NUMERIC],
            ],
            CUSTOM_ITEM_ENTITY_TYPE => [
                INPUT_NAME => CUSTOM_ITEM_ENTITY_TYPE,
                RULES => [NOT_EMPTY],
            ],
            /*CAX_REQUEST_NAME_KEY => [
                INPUT_NAME => CAX_REQUEST_NAME_KEY,
                RULES => [NOT_EMPTY], //TODO::
            ]*/
        ],
    ],

    'get_custom_item' => [
        REQUEST_URL_KEY => 'fields/{id}',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => CUSTOM_ITEM,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            CUSTOM_ITEM_ID => [
                INPUT_NAME => CUSTOM_ITEM_ID,
                RULES => [NOT_EMPTY],
            ],
            CAX_REQUEST_NAME_KEY => [
                INPUT_NAME => CAX_REQUEST_NAME_KEY,
                RULES => [NOT_EMPTY], //TODO::
            ]
        ]
    ],

    'get_custom_item_list' => [
        REQUEST_URL_KEY => 'fields',
        REQUEST_TYPE_KEY => JSON,
        REQUEST_METHOD_KEY => GET,
        RESPONSE_TYPE_KEY => JSON,
        AUTH_TYPE_KEY => BASIC_AUTH,
        PMS_REQUEST_MAPPER_FILE => CUSTOM_ITEM,
        EXTRA_DATA_KEY => [],
        INPUT_VALIDATION_RULES => [
            CAX_REQUEST_NAME_KEY => [
                INPUT_NAME => CAX_REQUEST_NAME_KEY,
                RULES => [NOT_EMPTY], //TODO::
            ]
        ]
    ],
];