<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [
    'id' => 'Profiles.0.UniqueID',
    'first_name' => 'Profiles.0.GivenName',
    'last_name' => 'Profiles.0.Surname',
    'addresses.0.city' => 'Profiles.0.CityName',
    'addresses.0.country' => 'Profiles.0.CountryName',
    'addresses.0.postal_code' => 'Profiles.0.PostalCode',
    'addresses' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_address_line",
    'email_addresses' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_emails",
    'phones' => "__FILE__$mapper_helper_file@__FUNCTION__set_guest_phones",
];

?>