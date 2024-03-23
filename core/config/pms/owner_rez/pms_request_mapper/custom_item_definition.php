<?php

/**
 * Define all request parameters in this file for fetching the Custom fields definitions requests from OwnerRez.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';

return [

    'custom_item_definition_single' => [
        CUSTOM_ITEM_DEFINITION_ID => 'id',
        CUSTOM_ITEM_DEFINITION_CODE => 'code',
        CUSTOM_ITEM_DEFINITION_NAME => 'name',
        CUSTOM_ITEM_DEFINITION_TYPE => 'type',
        CUSTOM_ITEM_DEFINITION_DESCRIPTION => 'description',
        CAX_REQUEST_NAME_KEY => CAX_REQUEST_NAME_KEY,


    ],

    'custom_item_definition_list' => [
        CUSTOM_ITEM_DEFINITION_TYPE => 'type',
        RECORD_LIMIT => RECORD_LIMIT,
        RECORD_OFFSET => RECORD_OFFSET,
        CAX_REQUEST_NAME_KEY => CAX_REQUEST_NAME_KEY,
    ],




];