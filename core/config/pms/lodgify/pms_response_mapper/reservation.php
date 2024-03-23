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
    'type' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'status' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'booked_utc' => 'CreateDateTime',
    'source' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',
    'arrival' => 'TimeSpan.Start',
    'departure' => 'TimeSpan.End',
    'currency.code' => 'RoomStay.Total.CurrencyCode',
    'source_text' => 'BookingChannel',

    //------------------- Reservation PropertyInfos --------------------
    'property_id' => 'BasicPropertyInfo.HotelCode',

    //-------------------- Reservation Guest--------------------------------
    'guest.id' => 'ResGuest.Profiles.0.UniqueID',
    'guest.name' => 'ResGuest.Profiles.0.GivenName',
    'guest.city' => 'Profiles.0.CityName',
    'guest.country_code' => 'ResGuest.Profiles.0.CountryName',
    'guest.postal_code' => 'ResGuest.Profiles.0.PostalCode',
    'guest.street_address1' => 'ResGuest.Profiles.0.AddressLine',
    'guest.email' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_emails",
    'guest.phone' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_phones",

    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    'people' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_adult_counts",

    // ----------- Reservation RoomStay Comments ----------------------------------------------
    'note' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_comments",

    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    'total_amount' => 'RoomStay.Total.AmountAfterTax',
    'total_paid' => 'RoomStay.Total.AmountPaid',

];

?>