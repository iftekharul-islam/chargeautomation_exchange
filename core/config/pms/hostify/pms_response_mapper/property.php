<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [
    'id' => 'HotelInformation.HotelCode',
    'name' => 'HotelInformation.Name',
    'nickname' => 'HotelInformation.NickName',
    'timezone' => 'HotelInformation.TimeZone',
    'currency' => 'HotelInformation.Currency',
    'checkin_start' => 'HotelInformation.CheckIn',
    'checkout' => 'HotelInformation.CheckOut',
    'countrycode' => 'HotelContactInformation.Address.CountryCode',
    'country' => 'HotelContactInformation.Address.CountryName',
    'lat' => 'HotelContactInformation.Address.Lat',
    'lng' => 'HotelContactInformation.Address.Lng',
    //'statecode' => 'HotelContactInformation.Address.StateCode',
    'state' => 'HotelContactInformation.Address.StateName',
    'city' => 'HotelContactInformation.Address.CityName',
    'zipcode' => 'HotelContactInformation.Address.ZipCode',
    'street' => 'HotelContactInformation.Address.AddressLine',
    'rooms' => "__FILE__$mapper_helper_file@__FUNCTION__set_property_facility_infos",
    //'address' => 'HotelContactInformation.Address.AddressLine',
    //'address' => "__FILE__$mapper_helper_file@__FUNCTION__set_property_contact_information",
];

?>