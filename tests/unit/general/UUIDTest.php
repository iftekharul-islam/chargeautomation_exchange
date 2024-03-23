<?php

namespace unit\general;

use PHPUnit\Framework\Attributes\DataProvider;
use TestCase;

require_once __DIR__ . '/../../../core/includes/autoload.php';

class UUIDTest extends TestCase
{

    /**
     * @param $table_name
     * @param $column_name
     * @throws \CaxException
     */
    #[DataProvider('uuidProvider')]
    public function testUuid($table_name, $column_name)
    {
        // Call the function with mock DB instance
        $result = generateUuId($table_name, $column_name);

        // Assert the result is a string and has a length of 13
        $this->assertIsString($result);
        $this->assertEquals(13, strlen($result));
    }


    public static function uuidProvider(): array
    {
        return [
            ['partners', 'api_key'],
            ['partner_users', 'credential_token']
        ];
    }
}
