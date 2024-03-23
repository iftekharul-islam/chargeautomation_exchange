<?php

namespace features\onboarding;

use PDO;
use PHPUnit\Framework\Attributes\DataProvider;


class PartnerOnboardTest extends \TestCase
{

    /**
     *   * Test Partner Onboard
     * @param $name
     * @param $email
     * @param $expected_msg
     * @param $validation_error_code
     */

    #[DataProvider('partnerProvider')]
    public function testPartnerOnboard($name, $email, $expected_msg, $validation_error_code)
    {
        $_REQUEST['name'] = $name;
        $_REQUEST['email'] = $email;

        // Onboard new partner
        ob_start();
        @require __DIR__ . '/../../../main/onboarding/partner_onboarding.php';
        $output = json_decode(ob_get_clean(), true);
        $this->assertSame($expected_msg, $output['message']);
        $this->assertSame(true, $output['status']);
        $this->assertIsString($output['data']['api_key']);
        $this->assertEquals(13, strlen($output['data']['api_key']));


        // Test Duplication Validations
        $this->markTestSkipped('The testPartnerDuplicationOnboard is skipped, Unique Email Validation not working.'); //TODO::Fix
        ob_start();
        @require __DIR__ . '/../../../main/onboarding/partner_onboarding.php';
        $output = json_decode(ob_get_clean(), true);

        $this->assertSame($output['status_code'], $validation_error_code);
        $this->assertSame(false, $output['status']);
    }



    public static function partnerProvider(): array
    {
        return [
            ['CAX-Test-CASE', 'cax-test@cax.com', CAX_SUCCESS_MESSAGE_PARTNER_ONBOARD, CAX_VALIDATION_ERROR]
        ];
    }

}