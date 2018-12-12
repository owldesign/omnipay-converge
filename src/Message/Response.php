<?php
namespace Omnipay\Converge\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Converge Response
 *
 * This is the response class for all Converge requests.
 *
 * @see \Omnipay\Converge\Gateway
 */
class Response extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        parse_str(implode('&', preg_split('/\n/', $data)), $this->data);
    }

    public function isSuccessful()
    {
        return isset($this->data['ssl_result']) && $this->data['ssl_result'] == 0;
    }

    public function getTransactionReference()
    {
        return isset($this->data['ssl_txn_id']) ? $this->data['ssl_txn_id'] : null;
    }

    public function getTransactionId()
    {
        return isset($this->data['ssl_txn_id']) ? $this->data['ssl_txn_id'] : null;
    }

    public function getCardReference()
    {
        return (isset($this->data['ssl_token'])) ? $this->data['ssl_token'] : null;
    }

    public function getMessage()
    {
        if (isset($this->data['errorCode']) && !$this->isSuccessful()) {
            return isset($this->data['errorMessage']) ? $this->data['errorMessage'] : null;
        }

        return isset($this->data['ssl_result_message']) ? $this->data['ssl_result_message'] : null;
    }

    public function getCode()
    {
        if (isset($this->data['errorCode']) && !$this->isSuccessful()) {
            return $this->data['errorCode'];
        }

        return $this->data['ssl_result'];
    }

    public function getCardToken()
    {
        return (isset($this->data['ssl_token'])) ? $this->data['ssl_token'] : null;
    }
}
