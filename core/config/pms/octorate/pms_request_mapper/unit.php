<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';
$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

return [

    //Single Unit
    PMS_ROOM_CODE => 'roomid',

    //List units
    PROPERTY_HOTEL_CODE => 'accommodation',
    RECORD_LIMIT => 'per_page',
//    PAGE => 'page',
    PAGE  => "__FILE__$mapper_helper_file@__FUNCTION__set_pagination",

];

?>