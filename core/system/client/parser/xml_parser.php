<?php
include_once __DIR__ . '/../../../exceptions/ExceptionCodes.php';
include_once __DIR__ . '/ArrayToXml.php';
include_once __DIR__ . '/../../../exceptions/CaxException.php';


/** This function create a json object from xml string.
 *
 * @param string $xml_string
 * @param array $options
 * @return bool|string
 * @throws JsonException
 */

function xml_to_json(string $xml_string, array $options = []): bool|string
{
    $xml = simplexml_load_string($xml_string);
    return json_encode(xml_to_array($xml, $options), JSON_THROW_ON_ERROR);
}

/** This function create an array from xml string.
 *
 * @param $xml
 * @param array $options
 * @return array
 */
function xml_to_array($xml, array $options = []): array
{
    $defaults = [
        'namespaceRecursive' => true, // Get XML doc namespaces recursively
        'removeNamespace' => true, // Remove namespace from resulting keys
        'namespaceSeparator' => ':', // Change separator to something other than a colon
        'attributePrefix' => '@', // Distinguish between attributes and nodes with the same name
        'alwaysArray' => [], // Array of XML tag names which should always become arrays
        'autoArray' => true, // Create arrays for tags which appear more than once
        'textContent' => 'text', // Key used for the text content of elements
        'autoText' => true, // Skip textContent key if node has no attributes or child nodes
        'keySearch' => false, // (Optional) search and replace on tag and attribute names
        'keyReplace' => false, // (Optional) replace values for above search values
    ];
    $options = array_merge($defaults, $options);

    $namespaces = $xml->getDocNamespaces($options['namespaceRecursive']);
    $namespaces[''] = null; // Add empty base namespace

    $attributesArray = [];
    $tagsArray = [];
    foreach ($namespaces as $prefix => $namespace) {
        if ($options['removeNamespace']) {
            $prefix = '';
        }
        // Get attributes from all namespaces
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            // (Optional) replace characters in attribute name
            if ($options['keySearch']) {
                $attributeName = str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            }
            $attributeKey = $options['attributePrefix'] . ($prefix ? $prefix . $options['namespaceSeparator'] : '') . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
        // Get child nodes from all namespaces
        foreach ($xml->children($namespace) as $childXml) {
            // Recurse into child nodes
            $childArray = xml_to_array($childXml, $options);
            $childTagName = key($childArray);
            $childProperties = current($childArray);

            // Replace characters in tag name
            if ($options['keySearch']) {
                $childTagName = str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            }

            // Add namespace prefix, if any
            if ($prefix) {
                $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
            }

            if (!isset($tagsArray[$childTagName])) {
                // Only entry with this key
                // Test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] = in_array($childTagName, $options['alwaysArray'], true) || !$options['autoArray'] ? [$childProperties] : $childProperties;
            } elseif (is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName]) === range(0, count($tagsArray[$childTagName]) - 1)) {
                // Key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                // Key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = [$tagsArray[$childTagName], $childProperties];
            }
        }
    }

    // Get text content of node
    $textContentArray = [];
    $plainText = trim((string)$xml);
    if ($plainText !== '') {
        $textContentArray[$options['textContent']] = $plainText;
    }

    // Stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || $plainText === '' ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

    // Return node as array
    return [
        $xml->getName() => $propertiesArray,
    ];
}

/** This function create a xml object with element root.
 *
 * @param string $string
 * @return string
 * @throws CaxException
 */

function json_to_xml(string $string): string
{
    try {
        /*$root = [
            'rootElementName' => 'soap:Envelope',
            '_attributes' => [
                'xmlns:soap' => 'http://www.w3.org/2003/05/soap-envelope/',
            ],
        ];*/
        $array = json_decode($string, TRUE, 512, JSON_THROW_ON_ERROR);

        /*array_walk($array, static function($value, $key) use (&$array){
            if($key == 'Envelop'){
                $array[$key] = 'soap:Envelop';
            }
            if($key == 'Header'){
                $array[$key] = 'soap:Header';
            }
            if($key == 'Body'){
                $array[$key] = 'soap:Body';
            }
        });*/

        return ArrayToXml::convert($array);

    } catch (Exception $exception) {
        throw new CaxException($exception->getMessage(), CAX_INVALID_XML_ERROR, $exception);
    }
}

/** function definition to convert array to xml recursive
 *
 * @param array $array
 * @param $xml_info
 */
function set_child_attribute(array $array, &$xml_info): void
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            if (!is_numeric($key)) {
                $sub_node = $xml_info->addChild((string)$key);
            } else {
                $sub_node = $xml_info->addChild("item$key");
            }
            set_child_attribute($value, $sub_node);
        } else {
            $xml_info->addChild((string)$key, htmlspecialchars((string)$value));
        }
    }
}


