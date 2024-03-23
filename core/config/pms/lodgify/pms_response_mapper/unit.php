<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all units response parameters in this file to send to the partner user.
 * on the left side of the array write the key that will come from pms response and
the key that we will send the CAX response to the partner user on the right side of the array.
 */
return [
    'Id' => 'id',
    'Name' => 'name'
];

?>