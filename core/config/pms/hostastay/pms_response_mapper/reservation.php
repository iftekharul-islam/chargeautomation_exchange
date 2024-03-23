<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [

    //-------------------------- ReservationInfo --------------------
    'code' => 'ID',
    'status' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'source' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',
    'created_at' => 'CreateDateTime',
    'updated_at' => 'LastModifyDateTime',
    'listing_site' => 'BookingChannel',
    'check_in_date' => 'TimeSpan.Start',
    'check_out_date' => 'TimeSpan.End',
    'currency_code' => 'RoomStay.Total.CurrencyCode',

    //------------------- Reservation PropertyInfos --------------------
    'unit_id' => 'BasicPropertyInfo.HotelCode', //TODO::Pending Support Confirmation

    //-------------------- Reservation Guest--------------------------------
    'guest_id' => 'ResGuest.Profiles.0.UniqueID',
    'guest_details.first_name' => 'ResGuest.Profiles.0.GivenName',
    'guest_details.last_name' => 'ResGuest.Profiles.0.Surname',
    'guest_details.email' => 'ResGuest.Profiles.0.Emails.0',
    'guest_details.contact_no' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_phones",


    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    'guest_details.number_of_pax' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_adult_counts",

    // ----------- Reservation RoomStay Comments ----------------------------------------------
    'remarks' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_comments",

    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    'price_details' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_price",
];

?>