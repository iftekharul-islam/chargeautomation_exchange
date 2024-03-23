<?php

/**
 * Define all request parameters in this file for fetching the Custom fields definitions requests from OwnerRez.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';

return [

    'custom_item_single' => [
        CUSTOM_ITEM_ID => 'id',
        CUSTOM_ITEM_VALUE => 'value',
        CUSTOM_ITEM_ENTITY_ID => 'entity_id',
        CUSTOM_ITEM_ENTITY_TYPE => 'entity_type',
        CUSTOM_ITEM_VALUE_DEFINITION_ID => 'field_definition_id',
        //CAX_REQUEST_NAME_KEY => CAX_REQUEST_NAME_KEY,

    ],

    'custom_item_list' => [
        CUSTOM_ITEM_ENTITY_ID => 'entity_id',
        CUSTOM_ITEM_ENTITY_TYPE => 'entity_type',
        CUSTOM_ITEM_VALUE_DEFINITION_ID => 'field_definition_id',
        //CAX_REQUEST_NAME_KEY => CAX_REQUEST_NAME_KEY,
        RECORD_LIMIT => RECORD_LIMIT,
        RECORD_OFFSET => RECORD_OFFSET,
    ],


];