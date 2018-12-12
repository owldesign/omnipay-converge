<?php

namespace Omnipay\Converge\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $testEndpoint = 'https://api.demo.convergepay.com/VirtualMerchantDemo/process.do';
    protected $liveEndpoint = 'https://api.convergepay.com/VirtualMerchant/process.do';

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getUserId()
    {
        return $this->getParameter('userId');
    }

    public function setUserId($value)
    {
        return $this->setParameter('userId', $value);
    }

    public function getPin()
    {
        return $this->getParameter('pin');
    }

    public function setPin($value)
    {
        return $this->setParameter('pin', $value);
    }

    public function getSslShowForm()
    {
        return $this->getParameter('ssl_show_form');
    }

    public function getSslSalesTax()
    {
        return $this->getParameter('ssl_salestax');
    }

    public function setSslSalesTax($value)
    {
        return $this->setParameter('ssl_salestax', $value);
    }

    public function getSslInvoiceNumber()
    {
        return $this->getParameter('ssl_invoice_number');
    }

    public function setSslInvoiceNumber($value)
    {
        return $this->setParameter('ssl_invoice_number', $value);
    }

    public function setSslShowForm($value)
    {
        return $this->setParameter('ssl_show_form', $value);
    }

    public function getIntegrationTesting()
    {
        return $this->getParameter('integrationTesting');
    }

    public function setIntegrationTesting($value)
    {
        return $this->setParameter('integrationTesting', $value);
    }

    public function getSslResultFormat()
    {
        return $this->getParameter('ssl_result_format');
    }

    public function setSslResultFormat($value)
    {
        return $this->setParameter('ssl_result_format', $value);
    }

    protected function getBaseData()
    {
        $data = array(
            'ssl_merchant_id' => $this->getMerchantId(),
            'ssl_user_id' => $this->getUserId(),
            'ssl_pin' => $this->getPin(),
            'ssl_test_mode' => ($this->getTestMode() && !$this->getIntegrationTesting()) ? 'true' : 'false',
            'ssl_show_form' => ($this->getSslShowForm() && ($this->getSslShowForm() != 'false')) ? 'true' : 'false',
            'ssl_result_format' => $this->getSslResultFormat(),
            'ssl_invoice_number' => $this->getSslInvoiceNumber(),
        );

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ], http_build_query($data));

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    protected function createResponse($response)
    {
        return $this->response = new Response($this, $response);
    }
}