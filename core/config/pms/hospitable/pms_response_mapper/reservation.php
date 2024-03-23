<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [

    //-------------------------- ReservationInfo --------------------
    'uuid' => 'ID',
    'reservation_code' => 'ResCode',
    'status' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'booked_at' => 'CreateDateTime',
    'provider' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',
    'check_in' => 'TimeSpan.Start',
    'check_out' => 'TimeSpan.End',

    //------------------- Reservation PropertyInfos --------------------
    'property_id' => 'BasicPropertyInfo.HotelCode',

    //-------------------- Reservation Guest--------------------------------
    'guest_uuid' => 'ResGuest.Profiles.0.UniqueID',
    '_included.0.data.first_name' => 'ResGuest.Profiles.0.GivenName',
    '_included.0.data.last_name' => 'ResGuest.Profiles.0.Surname',
    '_included.0.data.email' => 'ResGuest.Profiles.0.Emails.0',
    '_included.0.data.phone' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_phones",

    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    'occupancy' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_guest_counts",


    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    'subtotal.currency' => 'RoomStay.Total.CurrencyCode',
    'subtotal.amount' =>  "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_amount_after_and_before_tax",
    'financials.guest.total_price.amount' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_total_amount",
];

?>