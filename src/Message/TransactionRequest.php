<?php
namespace Omnipay\Converge\Message;

/**
 * Converge Complete/Capture/Void/Refund Request
 *
 * This is the request that will be called for any transaction which submits a transactionReference.
 */
abstract class TransactionRequest extends AbstractRequest
{
    protected $transactionType;

    public function getData()
    {
        $this->manageValidate();

        $data = array(
            'ssl_transaction_type'=>$this->transactionType,
            'ssl_txn_id'=>$this->getTransactionReference(),
            'ssl_amount'=>$this->getAmount()
        );

        return array_merge($this->getBaseData(), $data);
    }

    abstract protected function manageValidate();

}
