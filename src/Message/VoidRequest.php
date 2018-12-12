<?php
namespace Omnipay\Converge\Message;

/**
 * Converge Authorize/Purchase Request
 *
 * This is the request that will be called for any transaction which submits a credit card,
 * including `authorize` and `purchase`
 */
class VoidRequest extends TransactionRequest
{
    protected $transactionType = 'ccvoid';

    protected function manageValidate()
    {
        $this->validate('transactionReference');
    }

    public function getData()
    {
        $this->manageValidate();

        $data = array(
            'ssl_transaction_type'=>$this->transactionType,
            'ssl_txn_id'=>$this->getTransactionReference()
        );

        return array_merge($this->getBaseData(), $data);
    }
}
