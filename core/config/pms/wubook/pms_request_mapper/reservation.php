<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';

/**
 * Define all request parameters in this file for fetching the reservation requests from the PMS.
 * Put the request key of CAX constant on the left side of the array and the key that is used to request to PMS on the right side.
 */

return [
    RESERVATION_CONFIRMATION_NUMBER_TYPE => null,
    RESERVATION_CONFIRMATION_NUMBER => null,
    RESERVATION_RETURN_FIXED_CHARGES => null,
    RESERVATION_PMS_RESERVATION_ID => null,
    RESERVATION_REFERENCE_NUMBER => null,
    RESERVATION_REFERENCE_TYPE => null,
    RESERVATION_CAN_HANDLE_VAULTED_CREDIT_CARD => null,
    RESERVATION_HOTEL_REFERENCE_CHAIN_CODE => null,
    RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => null,
    RESERVATION_PMS_RESERVATION_STATUS => null,
    RESERVATION_CREATED_USER_ID => null,
    RESERVATION_UPDATED_USER_ID => null,
    RESERVATION_CREATED_DATE => null,
    RESERVATION_UPDATED_DATE => null,
    RESERVATION_TOTAL_CREDIT_CARD_SURCHARGES => null,
    RESERVATION_CHECK_OUT_TIME => null,
    RESERVATION_COMPUTED_RESERVATION_STATUS => null,
    RESERVATION_START_DATE => null,
    RESERVATION_END_DATE => null,
    RESERVATION_NOTES => null,
];

?>