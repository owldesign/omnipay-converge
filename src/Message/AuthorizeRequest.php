<?php
namespace Omnipay\Converge\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * Converge Authorize/Purchase Request
 *
 * This is the request that will be called for any transaction which submits a credit card,
 * including `authorize` and `purchase`
 */
class AuthorizeRequest extends AbstractRequest
{
    protected $transactionType = 'ccauthonly';

    public function getData()
    {
        if ($this->getCard() != null) {
            $this->validate('amount', 'card');
            $this->getCard()->validate();

            $data = array(
                'ssl_amount' => $this->getAmount(),
                'ssl_salestax' => $this->getSslSalesTax(),
                'ssl_transaction_type' => $this->transactionType,
                'ssl_card_number' => $this->getCard()->getNumber(),
                'ssl_exp_date' => $this->getCard()->getExpiryDate('my'),
                'ssl_cvv2cvc2' => $this->getCard()->getCvv(),
                'ssl_cvv2cvc2_indicator' => ($this->getCard()->getCvv()) ? 1 : 0,
                'ssl_first_name' => $this->getCard()->getFirstName(),
                'ssl_last_name' => $this->getCard()->getLastName(),
                'ssl_email' => $this->getCard()->getEmail(),
                'ssl_phone' => $this->getCard()->getPhone(),
                'ssl_avs_address' => $this->getCard()->getAddress1(),
                'ssl_address2' => $this->getCard()->getAddress2(),
                'ssl_city' => $this->getCard()->getCity(),
                'ssl_state' => $this->getCard()->getState(),
                'ssl_country' => $this->getCard()->getCountry(),
                'ssl_customer_code' => $this->getDescription(),
                'ssl_avs_zip' => $this->getCard()->getPostcode()
            );
        } elseif ($this->getCardReference() != null) {
            $this->validate('amount');

            $data = array(
                'ssl_show_form' => 'false',
                'ssl_result_format' => 'ASCII',
                'ssl_amount' => $this->getAmount(),
                'ssl_salestax' => $this->getSslSalesTax(),
                'ssl_transaction_type' => $this->transactionType,
                'ssl_token' => $this->getCardReference(),
                'ssl_customer_code' => $this->getDescription(),
            );
        }

        return array_merge($this->getBaseData(), $data);
    }
}
