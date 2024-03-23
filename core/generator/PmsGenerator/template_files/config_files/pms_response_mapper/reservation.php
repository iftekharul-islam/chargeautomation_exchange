<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all reservation response parameters in this file to send to the partner user.
 * on the left side of the array write the key that will come from pms response and
the key that we will send the CAX response to the partner user on the right side of the array.
 */

return [
    '' => 'ID',
    '' => 'ResCode',
    '' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    '' => 'CreateDateTime',
    '' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',
    '' => 'TimeSpan.Start',
    '' => 'TimeSpan.End',

    //------------------- Reservation PropertyInfos --------------------
    '' => 'BasicPropertyInfo.HotelCode',

    //-------------------- Reservation Guest--------------------------------
    '' => 'ResGuest.Profiles.0.UniqueID',
    '' => 'ResGuest.Profiles.0.GivenName',
    '' => 'ResGuest.Profiles.0.Surname',
    '' => 'ResGuest.Profiles.0.Emails.0',
    '' => "ResGuest.Profiles.0.Telephone",

    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    '' => "RoomStay.GuestCounts",


    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    '' => 'RoomStay.Total.CurrencyCode',
    '' => 'RoomStay.Total.AmountAfterTax',
    '' => 'RoomStay.Total.AmountAfterTax',
    '' => 'RoomStay.Total.AmountPaid',
];

?>