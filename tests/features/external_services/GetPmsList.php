<?php

namespace features\external_services;

use TestCase;

class GetPmsList extends TestCase
{
    private $expected_data;
    private $actual_data;

    /*
     * setUp function automatically called before run unitTest method this function setUp our environment
     */
    protected function setUp(): void
    {
        $this->expected_data = getPmsListExpectedData();
        ob_start();
        @require __DIR__ . '/../../../main/list_pms.php';
        $this->actual_data = json_decode(ob_get_clean(), true);
        ob_flush();
    }

    public function testGetPmsList(): void
    {
        $this->assertTrue($this->actual_data['status']);
        $this->assertEquals(CAX_SUCCESS_RESPONSE_CODE, $this->actual_data['status_code']);
        $this->assertNotEmpty($this->actual_data['data']);
        $this->assertNotEmpty($this->expected_data);
        $this->assertEquals($this->expected_data, $this->actual_data['data']);
    }

    public function testGetPmsListWrongData(): void
    {
        unset($this->expected_data[0]);
        $this->assertNotEquals($this->expected_data, $this->actual_data['data']);
    }
}

function getPmsListExpectedData()
{
    $dir = __DIR__ . '/../core/config/pms';
    $pms = [];
    $files = scandir($dir);
    foreach ($files as $file) {

        if (is_dir($dir . '/' . $file) && !in_array($file, array('.', '..')) && substr($file, 0, 1) !== '.') {
            if ($file == 'opera') { continue; }

            if (!file_exists($dir . '/' . $file.'/manifest.json')) {
                sendLogToSlack('Missing manifest.json file', ['PMS' => $file]);
                continue;
            }

            $json_data = file_get_contents($dir . '/' . $file.'/manifest.json');
            $data = json_decode($json_data);

            $pms[] = [
                'DisplayName' => $data->display_name,
                'PmsUrl' => $data->url,
                'Description' => $data->description,
                'CaxName' => $data->name,
                'OnboardRedirection' => str_contains($data->user_onboard->type, 'OAuth'),
                'Credentials' => $data->user_onboard->credentials
            ];
        }
    }
    return $pms;
}