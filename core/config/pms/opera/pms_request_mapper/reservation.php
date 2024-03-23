<?php

/**
 * Define all request parameters in this file for fetching the reservation requests from Opera.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';
return [

    /***** Start keys For Single Reservation *****/

    //A unique ID representation of the confirmation ID
    RESERVATION_CONFIRMATION_NUMBER_TYPE => 'Envelope.Body.FetchBookingRequest.ConfirmationNumber.@type',
    RESERVATION_CONFIRMATION_NUMBER => 'Envelope.Body.FetchBookingRequest.ConfirmationNumber.@value',

    //A “Y” indicates fixed charges will be returned in the response.
    RESERVATION_RETURN_FIXED_CHARGES => 'Envelope.Body.FetchBookingRequest.ReturnFixedCharges',

    //The internal Reservation Name ID.
    RESERVATION_PMS_RESERVATION_ID => 'Envelope.Body.FetchBookingRequest.ResvNameId.@value',

    //REFERENCE NUMBER
    RESERVATION_REFERENCE_NUMBER => 'Envelope.Body.FetchBookingRequest.ExternalSystemNumber.ReferenceNumber',
    RESERVATION_REFERENCE_TYPE => 'Envelope.Body.FetchBookingRequest.ExternalSystemNumber.ReferenceType',

    //Indicates if the external system can handle vaulted credit cards. When “true,” the vaulted credit card ID will be returned in the response message.
    RESERVATION_CAN_HANDLE_VAULTED_CREDIT_CARD => 'Envelope.Body.FetchBookingRequest.@canHandleVaultedCreditCard',

    /*****End keys For Single Reservation*****/
    /*****Start keys For Reservations List*****/

    //Refers to the hotel to include in the query. This element is more for reference purposes.
    RESERVATION_HOTEL_REFERENCE_CHAIN_CODE => 'Envelope.Body.FetchBookingRequest.HotelReference.@chainCode',
    RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => 'Envelope.Body.FetchBookingRequest.HotelReference.@hotelCode',

    //The reservation status.
    //Type: attribute
    //Data Type: ReservationStatusType
    RESERVATION_PMS_RESERVATION_STATUS => 'Envelope.Body.FetchBookingRequest.reservationStatus',

    //The ID of the user who created the reservation.
    //Type: attribute
    //Data Type: string
    RESERVATION_CREATED_USER_ID => 'Envelope.Body.FetchBookingRequest.insertUser',

    //The ID of the user who last updated the reservation.
    //Type: attribute
    //Data Type: string
    RESERVATION_UPDATED_USER_ID => 'Envelope.Body.FetchBookingRequest.updateUser',

    //The date when the reservation is created.
    //Type: attribute
    //Data Type: dateTime
    RESERVATION_CREATED_DATE => 'Envelope.Body.FetchBookingRequest.insertDate',

    //The date when the reservation was last changed.
    //Type: attribute
    //Data Type: dateTime
    RESERVATION_UPDATED_DATE => 'Envelope.Body.FetchBookingRequest.updateDate',

    //The total credit card surcharges to be applied.
    //Type: attribute
    //Data Type: double
    RESERVATION_TOTAL_CREDIT_CARD_SURCHARGES => 'Envelope.Body.FetchBookingRequest.totalCreditCardSurcharges',

    //The estimated Check-Out time for the reservation
    //Type: attribute
    //Data Type: time
    RESERVATION_CHECK_OUT_TIME => 'Envelope.Body.FetchBookingRequest.checkOutTime',

    //The status of the reservation (i.e. “Checked In”, etc).
    //Type: attribute
    //Data Type: ReservationStatusType
    RESERVATION_COMPUTED_RESERVATION_STATUS => 'Envelope.Body.FetchBookingRequest.computedReservationStatus',

    /*****End keys For Reservations List*****/
];