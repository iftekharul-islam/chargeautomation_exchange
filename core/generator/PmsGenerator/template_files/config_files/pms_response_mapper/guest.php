<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all guest response parameters in this file to send to the partner user.
 * on the left side of the array write the key that will come from pms response and
the key that we will send the CAX response to the partner user on the right side of the array.
 */

return [
    '' => 'Profiles.0.UniqueID',
    '' => 'Profiles.0.GivenName',
    '' => 'Profiles.0.Surname',
    '' => 'Profiles.0.CityName',
    '' => 'Profiles.0.CountryName',
    '' => 'Profiles.0.PostalCode',
    '' => "Profiles.0.AddressLine",
    '' => "Profiles.0.Emails.0",
    '' => "Profiles.0.Telephone",
];

?>