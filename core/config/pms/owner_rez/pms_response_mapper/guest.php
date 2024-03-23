<?php

/**
 * Notes:
 *
 * To simply map PMS keys to Key on CA-x just write down the PMS key on left side
 * and write CA-X instance key on right side to where the actual value would be mapped.
 *
 * To map any kind of complex key as per your own custom logics or nested index wise keys
 * __FILE__{FILE-PATH}@__FUNCTION__{FunctionName}
 *
 * Use the provided formatted function path this function will be auto called by mapper_helper to map complex keys
 * for example reference '__FILE__$mapper_helper_file@__FUNCTION__set_reservation_room_rates'
 * Look into set_reservation_room_rates function of $mapper_helper_file.php file
 *
 */
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
