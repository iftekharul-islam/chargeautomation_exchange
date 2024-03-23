<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all reservation response parameters in this file to send to the partner user.
 * on the left side of the array write the key that will come from pms response and
the key that we will send the CAX response to the partner user on the right side of the array.
 */

return [

    //-------------------------- ReservationInfo --------------------
    'id' => 'ID',
    'refer' => 'ResCode', //
    'status' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'channelId' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',

    'createTime' =>  "__FILE__$mapper_helper_file@__FUNCTION__set_bookingTime",
    'checkin' =>  "__FILE__$mapper_helper_file@__FUNCTION__set_checkin",
    'checkout' =>  "__FILE__$mapper_helper_file@__FUNCTION__set_checkout",

    'source' => 'BookingChannel',
    'currency' => 'RoomStay.Total.CurrencyCode',

    'product' => 'RoomStay.RoomType.RoomID',

    //------------------- Reservation PropertyInfos --------------------
    'accommodation.id' => 'BasicPropertyInfo.HotelCode',
    'accommodation.name' => 'BasicPropertyInfo.HotelName',

    //-------------------- Reservation Guest--------------------------------
    'guests.0.familyName' => 'ResGuest.Profiles.0.Surname',
    'guests.0.givenName' => 'ResGuest.Profiles.0.GivenName',
    'guests.0.email' => 'ResGuest.Profiles.0.Emails.0',
    'guests.0.phone' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_phones",

    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    'totalInfants' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_infant_counts",
    'totalChildren' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_child_counts",
    'totalGuest' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_guest_counts",

    // ----------- Reservation RoomStay Comments ----------------------------------------------

    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    'totalGross' => 'RoomStay.Total.AmountAfterTax',


    // ----------- Reservation DepositPayments Array ----------------------------------------------
//    'payments' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_deposit_payments",
];

?>