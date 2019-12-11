<?php

namespace Assetku\BankService\tests;

use GuzzleHttp\Exception\GuzzleException;

class UpdateKycStatusTest extends TestCase
{
    public function testSuccessUpdateKycStatus()
    {
        $custRefId = \mt_rand(00000, 99999);

        $data = [
            'ReffCode' => 'U061219011270',
            'IdNumber' => '4610815675045937',
            'KycStatus' => '00',
            'KycFailedReason' => ''
        ];

        try {
            $updateKycRequest = \Bank::updateKycStatus($data, $custRefId);

            dd($updateKycRequest);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}
