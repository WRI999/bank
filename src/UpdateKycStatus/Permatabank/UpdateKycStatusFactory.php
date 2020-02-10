<?php

namespace Assetku\BankService\UpdateKycStatus\Permatabank;

use Assetku\BankService\Contracts\UpdateKycStatus\UpdateKycStatusFactoryContract;
use Assetku\BankService\Contracts\UpdateKycStatus\UpdateKycStatusRequestContract;

class UpdateKycStatusFactory implements UpdateKycStatusFactoryContract
{
    /**
     * @inheritDoc
     */
    public function makeRequest(string $referralCode, string $idNumber, string $kycStatus)
    {
        return new UpdateKycStatusRequest($referralCode, $idNumber, $kycStatus);
    }

    /**
     * @inheritDoc
     */
    public function makeResponse(UpdateKycStatusRequestContract $request, string $contents)
    {
        $data = json_decode($contents, true);

        $response = $data['UpdateKycFlagRs'];

        return new UpdateKycStatusResponse($response['MsgRsHdr']);
    }
}
