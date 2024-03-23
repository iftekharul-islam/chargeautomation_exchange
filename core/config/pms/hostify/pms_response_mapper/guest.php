<?php
$mapper_helper_file = getPMSManifest()['mapper_helper_file'];
return [
    'id' => 'Profiles.0.UniqueID',
    'name' => 'Profiles.0.GivenName',
    //'last_name' => 'Profiles.0.Surname',
    'city' => 'Profiles.0.CityName',
    'country' => 'Profiles.0.CountryName',
    'zip_code' => 'Profiles.0.PostalCode',
    'address' => 'Profiles.0.AddressLine',
    'email' => 'Profiles.0.Emails.0',
    'phone' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_phones",
];

?>