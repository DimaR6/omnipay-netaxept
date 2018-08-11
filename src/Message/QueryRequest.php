<?php

namespace Omnipay\Netaxept\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Netaxept
 */
class QueryRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://epayment.nets.eu';
    protected $testEndpoint = 'https://test.epayment.nets.eu';

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getData()
    {
        $this->validate('transactionId');

        $data = array();
        $data['merchantId'] = $this->getMerchantId();
        $data['token'] = $this->getPassword();
        $data['transactionId'] = $this->getTransactionId();

        return $data;
    }

    public function sendData($data)
    {
        $url = $this->getEndpoint().'/Netaxept/Query.aspx?';

        $httpResponse = $this->httpClient->get($url.http_build_query($data))->send();

        return $this->response = new Response($this, $httpResponse->xml());
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
