<?php

/**
 * Define request parameters as constants in this file.
 */

    //Reservation
    const RESERVATION_CONFIRMATION_NUMBER_TYPE = 'confirmation_type';
    const RESERVATION_CONFIRMATION_NUMBER = 'confirmation_code';
    const RESERVATION_RETURN_FIXED_CHARGES = 'return_fixed_charges';
    const RESERVATION_PMS_RESERVATION_ID = 'pms_reservation_id';
    const RESERVATION_REFERENCE_NUMBER = 'reference_number';
    const RESERVATION_REFERENCE_TYPE = 'reference_type';
    const RESERVATION_CAN_HANDLE_VAULTED_CREDIT_CARD = 'can_handle_vaulted_credit_card';
    const RESERVATION_HOTEL_REFERENCE_CHAIN_CODE = 'hotel_reference_chain_code';
    const RESERVATION_HOTEL_REFERENCE_HOTEL_CODE = 'hotel_reference_hotel_code';
    const RESERVATION_PMS_RESERVATION_STATUS = 'pms_reservation_status';
    const RESERVATION_CREATED_USER_ID = 'created_user_id';
    const RESERVATION_UPDATED_USER_ID = 'updated_user_id';
    const RESERVATION_CREATED_DATE = 'created_date';
    const RESERVATION_UPDATED_DATE = 'updated_date';
    const RESERVATION_TOTAL_CREDIT_CARD_SURCHARGES = 'total_credit_card_surcharges';
    const RESERVATION_CHECK_OUT_TIME = 'check_out_time';
    const RESERVATION_COMPUTED_RESERVATION_STATUS = 'computed_reservation_status';
    const RESERVATION_START_DATE = 'start_date';
    const RESERVATION_END_DATE = 'end_date';
    const RESERVATION_NOTES = 'notes';

    //Guest
    const RESERVATION_GUEST_ID = 'pms_guest_id';
    const RESERVATION_GUEST_FIRST_NAME = 'guest_first_name';
    const RESERVATION_GUEST_LAST_NAME = 'guest_last_name';
    const RESERVATION_GUEST_PHONE = 'guest_phone';
    const RESERVATION_GUEST_EMAIL = 'guest_email';

    //Property
    const PROPERTY_CONTACT_EMAILS = 'contact_emails';
    const PROPERTY_CONTACT_PHONES = 'contact_phones';
    const PROPERTY_CHAIN_CODE = 'chain_code';
    const PROPERTY_HOTEL_CODE = 'hotel_code';


    //Custom Field definition
    const CUSTOM_ITEM_DEFINITION_ID = 'id';
    const CUSTOM_ITEM_DEFINITION_TYPE = 'type';
    const CUSTOM_ITEM_DEFINITION_CODE = 'code';
    const CUSTOM_ITEM_DEFINITION_DESCRIPTION = 'description';
    const CUSTOM_ITEM_DEFINITION_NAME = 'name';

    const CUSTOM_ITEM_ID = 'id';
    const CUSTOM_ITEM_VALUE = 'value';
    const CUSTOM_ITEM_ENTITY_ID = 'entity_id';
    const CUSTOM_ITEM_ENTITY_TYPE = 'entity_type';
    const CUSTOM_ITEM_VALUE_DEFINITION_ID = 'field_definition_id';

    //CAX usage value (To route request dynamic on same endpoint)
    const CAX_REQUEST_NAME_KEY = 'request_name';

    const REQUEST_NAME_CUSTOM_FIELD_DEFINITION = 'custom_item_definition';
    const REQUEST_NAME_CUSTOM_FIELD = 'custom_item';


    //Room
    const PMS_ROOM_CODE = 'pms_room_id';

    //Generic
    const RECORD_LIMIT = 'limit';
    const PER_PAGE = 'per_page';
    const RECORD_OFFSET = 'offset';
    const PAGE = 'page';

