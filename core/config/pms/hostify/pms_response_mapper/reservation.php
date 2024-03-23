<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [

    //-------------------------- ReservationInfo --------------------
    'id' => 'ID',
    'confirmation_code' => 'ResCode',
    'status' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'created_at' => 'CreateDateTime',
    'source' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',
    'checkIn' => 'TimeSpan.Start',
    'checkOut' => 'TimeSpan.End',

    'currency' => 'RoomStay.Total.CurrencyCode',

    //------------------- Reservation PropertyInfos --------------------
    'listing_id' => 'BasicPropertyInfo.HotelCode',
    'parent_listing_id' => 'BasicPropertyInfo.ParentHotelCode',

    //-------------------- Reservation Guest--------------------------------
    'guest_id' => 'ResGuest.Profiles.0.UniqueID',

    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    'adults' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_adult_counts",
    'children' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_child_counts",
    'guests' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_guest_counts",

    // ----------- Reservation RoomStay Comments ----------------------------------------------
    'notes' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_comments",

    // ----------- Reservation RoomStay Total Array ----------------------------------------------
//    'subtotal' => 'RoomStay.Total.AmountAfterTax',
    'payout_price' => 'RoomStay.Total.AmountAfterTax',
    'paid_sum' => 'RoomStay.Total.AmountPaid',
];

?>