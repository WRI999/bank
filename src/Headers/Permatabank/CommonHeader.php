<?php

namespace Assetku\BankService\Headers\Permatabank;

use Assetku\BankService\Contracts\Header as HeaderContract;
use Assetku\BankService\Contracts\Requests\Request;
use Illuminate\Support\Collection;

class CommonHeader extends Header implements HeaderContract
{
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $instcode;

    /**
     * @var string
     */
    protected $organizationName;

    /**
     * CommonHeader constructor.
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->instcode = \Config::get('bank.providers.permatabank.instcode');

        $this->organizationName = \Config::get('bank.providers.permatabank.organization_name');

        $this->accessToken = \BankService::accessToken();
    }

    /**
     * @inheritDoc
     */
    public function content()
    {
        return [
            'Authorization'     => "Bearer {$this->accessToken}",
            'permata-signature' => $this->signature(),
            'organizationname'  => $this->organizationName,
            'permata-timestamp' => $this->request->timestamp(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function signature()
    {
        $trimmedData = Collection::make($this->request->data())->recursiveTrim()->toArray();

        $payload = $this->request->encoder()->encode($trimmedData);

        $data = "{$this->accessToken}:{$this->request->timestamp()}:{$payload}";

        return base64_encode(hash_hmac('sha256', $data, $this->staticKey, true));
    }
}
