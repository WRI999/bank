<?php

namespace Assetku\BankService\Requests\Permatabank;

use Assetku\BankService\Contracts\Requests\MustValidated;
use Assetku\BankService\Contracts\Requests\OverbookingInquiryRequest as OverbookingInquiryRequestContract;
use Assetku\BankService\Encoders\Permatabank\JsonEncoder;
use Assetku\BankService\Headers\Permatabank\CommonHeader;

class OverbookingInquiryRequest extends Request implements OverbookingInquiryRequestContract, MustValidated
{
    /**
     * @var string
     */
    protected $accountNumber;

    /**
     * OverbookingInquiryRequest constructor.
     *
     * @param  string  $accountNumber
     */
    public function __construct(string $accountNumber)
    {
        parent::__construct();

        $this->accountNumber = $accountNumber;
    }

    /**
     * @inheritDoc
     */
    public function accountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @inheritDoc
     */
    public function method()
    {
        return 'POST';
    }

    /**
     * @inheritDoc
     */
    public function uri()
    {
        return 'InquiryServices/AccountInfo/inq';
    }

    /**
     * @inheritDoc
     */
    public function encoder()
    {
        return new JsonEncoder;
    }

    /**
     * @inheritDoc
     */
    public function data()
    {
        return [
            'AcctInqRq' => [
                'MsgRqHdr' => [
                    'RequestTimestamp' => $this->timestamp,
                    'CustRefID'        => $this->customerReferenceId,
                ],
                'InqInfo'  => [
                    'AccountNumber' => $this->accountNumber,
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function header()
    {
        return new CommonHeader($this);
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'AcctInqRq'                           => 'required|array|size:2',
            'AcctInqRq.MsgRqHdr'                  => 'required|array|size:2',
            'AcctInqRq.MsgRqHdr.RequestTimestamp' => 'required|string|date',
            'AcctInqRq.MsgRqHdr.CustRefID'        => 'required|string|size:20',
            'AcctInqRq.InqInfo'                   => 'required|array|size:1',
            'AcctInqRq.InqInfo.AccountNumber'     => 'required|string|between:9,18',
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function customAttributes()
    {
        return [
            'AcctInqRq'                           => 'overbooking inquiry',
            'AcctInqRq.MsgRqHdr'                  => 'header permintaan pesan',
            'AcctInqRq.MsgRqHdr.RequestTimestamp' => 'timestamp',
            'AcctInqRq.MsgRqHdr.CustRefID'        => 'id referensi pelanggan',
            'AcctInqRq.InqInfo'                   => 'info inquiry',
            'AcctInqRq.InqInfo.AccountNumber'     => 'nomor rekening',
        ];
    }
}
