<?php


/**
 * /**
 * Use this function to map data values to a set pattern array.
 *
 * Map array key values recursively as per mapping pattern.
 * $data_to_map = ['others.comments' => 'My new notes.']
 * $mapping_pattern = ['others.notes' => 'guest.details.comments'],
 * then the function will map 'My new notes.' as
 * response an array: ['guest' => ['details' => ['comments' => 'My new notes.']]
 * $get_nested to false if don't want to explode key by '.' notation
 * $map_nested to false If don't want to map value to n index.
 * @param array $data_to_map
 * @param array $mapping_pattern
 * @param bool $get_nested
 * @param bool $map_nested
 * @return array
 */
function map_data(array $data_to_map, array $mapping_pattern, $get_nested = true, $map_nested=true): array
{
    $data = [];

    foreach ($mapping_pattern as $map_from_key => $map_to_key) {
        $value = getKeyValueRecursively($data_to_map, $map_from_key, $get_nested);
        if (!is_null($value)) {
            $map_to_key = $map_nested ? explode('.', $map_to_key) : [$map_to_key];
            push_mapped_value_recursively($data, $value, $map_to_key);
        }
    }

    return $data;
}


/**
 * Make data array by keyName recursively
 * e.g : 'others.notes' => ['others' => ['notes' => {$value} ]]
 * and push value to last the recursive index
 *
 * @param $data
 * @param $value_to_map
 * @param array $key_to_map
 * @param int $current_index
 */
function push_mapped_value_recursively(&$data, $value_to_map, array $key_to_map, $current_index = 0)
{
    $keysArrayCount = count($key_to_map);

    if ($current_index < $keysArrayCount) {

        if (!isset($data[$key_to_map[$current_index]])) {

            if ($current_index == $keysArrayCount - 1) {

                if (is_key_to_call_file_function($key_to_map[$current_index]) || is_key_to_call_file_function($value_to_map)) {
                    // Get file & function name from key name
                    $logic_path = explode('@__FUNCTION__', $key_to_map[$current_index]);

                    // Get file & function name from value, If not set in Key.
                    $logic_path = count($logic_path) == 2 ? $logic_path : explode('@__FUNCTION__', $value_to_map);

                    require_once __DIR__ . '/../' . str_replace('__FILE__', '', $logic_path[0]) . '.php';

                    $logic_path[1]($data, $value_to_map); //Call regarding files' method to reflect logical values
                    return; //return back recursive.

                } else {
                    $data[$key_to_map[$current_index]] = $value_to_map;
                }

            } elseif (!is_key_to_call_file_function($key_to_map[$current_index])) {
                $data[$key_to_map[$current_index]] = null;
            }
        }

        push_mapped_value_recursively(
            $data[$key_to_map[$current_index]],
            $value_to_map, $key_to_map, ++$current_index
        );

    }
}

/**
 * @param $key
 * @return bool
 */
function is_key_to_call_file_function($key): bool
{
    return is_string($key) && str_contains($key, '__FILE__') && str_contains($key, '@__FUNCTION__');
}


/**
 * @param $array
 * @param $key
 * @param bool $nested
 * @return mixed|null
 */
function getKeyValueRecursively($array, $key, $nested = true)
{
    $key_array = $nested ? explode('.', $key) : [$key];

    foreach ($key_array as $key => $item) {

        if (!isset($array[$item])) {
            if (is_numeric($item) && isset($array[(int)$item])) {
                $array = $array[(int)$item];
            } else {
                return null;
            }
        }

        $array = $array[$item];
    }

    return $array;
}