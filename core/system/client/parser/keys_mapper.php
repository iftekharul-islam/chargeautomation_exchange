<?php

require_once __DIR__ . '/../../../includes/autoload.php';
require_once __DIR__ . '/../../../../helpers/keys_mapper_helper.php';

/**
 * $pattern_type=> reservation, property, guest etc. key as set in config file
 * Response returns mapped data as regarding provisioned pms pattern type
 * $pattern_type => reservation_pattern, property_pattern
 * @param $pms_name
 * @param $pattern_type
 * @param array $data_to_map
 * @return array
 */
function map_pms_keys_to_partner_keys($pattern_type, array $data_to_map, $pms_name = '')
{
    if(empty($pms_name))
        $pms_name = getPmsName();

    $mapping_pattern = config("pms.$pms_name.pms_response_mapper.$pattern_type");

    if (is_null($mapping_pattern)) {
        return [];  //TODO::Throw General Exception
    }

    return map_data($data_to_map, $mapping_pattern);

}

/**
 * $pattern_type=> reservation, property, guest etc. key as set in config file
 * Response returns mapped data as regarding provisioned pms pattern type
 * @param $pms_name
 * @param $pattern_type
 * @param $pattern_index
 * @param array $data_to_map
 * @return array
 */
function map_partner_keys_to_pms_keys($pms_name, $pattern_type, $pattern_index, array $data_to_map)
{
    $mapping_pattern = config("pms.$pms_name.pms_request_mapper.$pattern_type", $pattern_index);

    if (is_null($mapping_pattern)) {
        return [];  //TODO::Throw General Exception
    }

    return map_data($data_to_map, $mapping_pattern);
}
