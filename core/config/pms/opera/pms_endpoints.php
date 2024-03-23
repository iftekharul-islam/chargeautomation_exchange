<?php
require_once __DIR__ . '/../../../const/pms_endpoints_const.php';
require_once __DIR__ . '/../../../system/cax_request_keys.php';
require_once __DIR__ . '/../../../system/cax_validation_rule_keys.php';

return [

    'get_booking' => [
        REQUEST_URL_KEY => 'http://localhost/chargeautomationexchange/main/dummy-response.php?booking=true', //TODO
        REQUEST_TYPE_KEY => XML,
        RESPONSE_TYPE_KEY => XML,
        REQUEST_METHOD_KEY => POST,
        AUTH_TYPE_KEY => NO_AUTH,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [
            'Envelope.Header.OGHeader.@transactionID' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_transaction_id',
            'Envelope.Header.OGHeader.@timeStamp' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_timestamp',
            'Envelope.Header.OGHeader.@primaryLangID' => 'E',
            'Envelope.Header.OGHeader.Origin.@entityID' => 'WEST',
            'Envelope.Header.OGHeader.Origin.@systemType' => 'WEB',
            'Envelope.Header.OGHeader.Destination.@entityID' => 'TI',
            'Envelope.Header.OGHeader.Destination.@systemType' => 'ORS',

        ],
        INPUT_VALIDATION_RULES => [
            RESERVATION_PMS_RESERVATION_ID => [
                INPUT_NAME => RESERVATION_PMS_RESERVATION_ID,
                RULES => [NOT_EMPTY],
            ],
        ],
    ],

    'get_booking_list' => [
        REQUEST_URL_KEY => 'http://localhost/chargeautomationexchange/main/dummy-response.php?booking=true',
        REQUEST_TYPE_KEY => XML,
        REQUEST_METHOD_KEY => POST,
        AUTH_TYPE_KEY => NO_AUTH,
        RESPONSE_TYPE_KEY => XML,
        PMS_REQUEST_MAPPER_FILE => RESERVATION,
        EXTRA_DATA_KEY => [
            'Envelope.Header.OGHeader.@transactionID' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_transaction_id',
            'Envelope.Header.OGHeader.@timeStamp' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_timestamp',
            'Envelope.Header.OGHeader.@primaryLangID' => 'E',
            'Envelope.Header.OGHeader.Origin.@entityID' => 'WEST',
            'Envelope.Header.OGHeader.Origin.@systemType' => 'WEB',
            'Envelope.Header.OGHeader.Destination.@entityID' => 'TI',
            'Envelope.Header.OGHeader.Destination.@systemType' => 'ORS',

        ],
        INPUT_VALIDATION_RULES => [
            RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => [
                INPUT_NAME => RESERVATION_HOTEL_REFERENCE_HOTEL_CODE,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_property' => [
        REQUEST_URL_KEY => 'http://localhost/chargeautomationexchange/main/dummy-response.php',
        REQUEST_TYPE_KEY => XML,
        REQUEST_METHOD_KEY => POST,
        AUTH_TYPE_KEY => NO_AUTH,
        RESPONSE_TYPE_KEY => XML,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [
            'Envelope.Header.OGHeader.@transactionID' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_transaction_id',
            'Envelope.Header.OGHeader.@timeStamp' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_timestamp',
            'Envelope.Header.OGHeader.@primaryLangID' => 'E',

        ],
        INPUT_VALIDATION_RULES => [
            PROPERTY_HOTEL_CODE => [
                INPUT_NAME => PROPERTY_HOTEL_CODE,
                RULES => [NOT_EMPTY,SHOULD_NUMERIC,NOT_SPECIAL_CHARACTERS],
            ],
        ],
    ],

    'get_property_list' => [
        REQUEST_URL_KEY => 'http://localhost/chargeautomationexchange/main/dummy-response.php',
        REQUEST_TYPE_KEY => XML,
        REQUEST_METHOD_KEY => POST,
        AUTH_TYPE_KEY => NO_AUTH,
        RESPONSE_TYPE_KEY => XML,
        PMS_REQUEST_MAPPER_FILE => PROPERTY,
        EXTRA_DATA_KEY => [
            'Envelope.Header.OGHeader.@transactionID' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_transaction_id',
            'Envelope.Header.OGHeader.@timeStamp' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_request_timestamp',
            'Envelope.Header.OGHeader.@primaryLangID' => 'E',

        ],
    ],
];