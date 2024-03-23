<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [
    'id' => 'HotelInformation.HotelCode',
    'name' => 'HotelInformation.Name',
    'timezone' => 'HotelInformation.TimeZone',
    'address' => "__FILE__$mapper_helper_file@__FUNCTION__set_property_contact_information",
    'currency' => 'HotelInformation.Currency',
];

?>