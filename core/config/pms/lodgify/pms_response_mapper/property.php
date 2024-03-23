<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all property response parameters in this file to send to the partner user.
 * on the left side of the array write the key that will come from pms response and
the key that we will send the CAX response to the partner user on the right side of the array.
 */

return [
    'id' => 'HotelInformation.HotelCode',
    'name' => 'HotelInformation.Name',
    'currency_code' => 'HotelInformation.Currency',
    'address' => "HotelContactInformation.Address.AddressLine",
    'city' => "HotelContactInformation.Address.CityName",
    'country' => "HotelContactInformation.Address.CountryCode",
    'zip' => "HotelContactInformation.Address.ZipCode",

    // lat, lng, rooms are only available on single property response
    'latitude' => "HotelContactInformation.Address.Lat",
    'longitude' => "HotelContactInformation.Address.Lng",
    'rooms' => "__FILE__$mapper_helper_file@__FUNCTION__set_property_units_information",
];

?>