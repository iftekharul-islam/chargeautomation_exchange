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
    'id' => 'id',
    'code' => 'code',
    'name' => 'name',
    'type' => 'type',
    'full_code' => 'full_code',
    'description' => 'description',
];
