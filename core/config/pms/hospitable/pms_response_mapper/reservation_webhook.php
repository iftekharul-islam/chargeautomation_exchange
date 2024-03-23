<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [

    //-------------------------- ReservationInfo --------------------
    'uuid' => 'ID',
    'code' => 'ResCode',
    'status' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'created_at' => 'CreateDateTime',
    'channel' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',
    'start_date' => 'TimeSpan.Start',
    'end_date' => 'TimeSpan.End',

    'currency' => 'RoomStay.Total.CurrencyCode',

    //------------------- Reservation PropertyInfos --------------------
    'listing.property_id' => 'BasicPropertyInfo.HotelCode',
    'listing.name' => 'BasicPropertyInfo.HotelName',

    //-------------------- Reservation Guest--------------------------------
    'guest.id' => 'ResGuest.Profiles.0.UniqueID',
    'guest.first_name' => 'ResGuest.Profiles.0.GivenName',
    'guest.last_name' => 'ResGuest.Profiles.0.Surname',
    'guest.email' => 'ResGuest.Profiles.0.Emails.0',
    'guest.phone' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_phones",

    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    //'occupancy' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_guest_counts", //TODO


    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    'total_price' => 'RoomStay.Total.AmountAfterTax',
];

?>