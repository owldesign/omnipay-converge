<?php
namespace Omnipay\Converge;

use Omnipay\Common\AbstractGateway;

/**
 * Converge Gateway
 *
 * This gateway is useful for testing. It implements all the functions listed in \Omnipay\Common\GatewayInterface
 * and allows both successful and failed responses based on the input.
 *
 * For authorize(), purchase(), and createCard() functions ...
 *
 *    Any card number which passes the Luhn algorithm and ends in an even number is authorized,
 *    for example: 4242424242424242
 *
 *    Any card number which passes the Luhn algorithm and ends in an odd number is declined,
 *    for example: 4111111111111111
 *
 * For capture(), completeAuthorize(), completePurchase(), refund(), and void() functions...
 *    A transactionReference option is required. If the transactionReference contains 'fail', the
 *    request fails. For any other values, the request succeeds
 *
 * For updateCard() and deleteCard() functions...
 *    A cardReference field is required. If the cardReference contains 'fail', the
 *    request fails. For all other values, it succeeds.
 *
 * ### Example
 * <code>
 * // Create a gateway for the Converge Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Converge');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'testMode' => true, // Doesn't really matter what you use here.
 * ));
 *
 * // Create a credit card object
 * // This card can be used for testing.
 * $card = new CreditCard(array(
 *             'firstName'    => 'Example',
 *             'lastName'     => 'Customer',
 *             'number'       => '4242424242424242',
 *             'expiryMonth'  => '01',
 *             'expiryYear'   => '2020',
 *             'cvv'          => '123',
 * ));
 *
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'amount'                   => '10.00',
 *     'currency'                 => 'AUD',
 *     'card'                     => $card,
 * ));
 * $response = $transaction->send();
 * if ($response->isSuccessful()) {
 *     echo "Purchase transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Converge';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'userId' => '',
            'pin' => '',
            'ssl_show_form' => false,
            'ssl_result_format' => 'ASCII'
        );
    }

    /**
     * Get the merchant ID
     *
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * Set the merchant ID
     *
     * @param $value
     * @return Gateway
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * Get the user ID
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->getParameter('userId');
    }

    /**
     * Set the user ID
     *
     * @param $value
     * @return Gateway
     */
    public function setUserId($value)
    {
        return $this->setParameter('userId', $value);
    }

    /**
     * Get the pin
     *
     * @return mixed
     */
    public function getPin()
    {
        return $this->getParameter('pin');
    }

    /**
     * Set the pin
     *
     * @param $value
     * @return Gateway
     */
    public function setPin($value)
    {
        return $this->setParameter('pin', $value);
    }

    public function getSslShowForm()
    {
        return $this->getParameter('ssl_show_form');
    }

    public function setSslShowForm($value)
    {
        return $this->setParameter('ssl_show_form', $value);
    }

    public function getSslResultFormat()
    {
        return $this->getParameter('ssl_result_format');
    }

    public function setSslResultFormat($value)
    {
        return $this->setParameter('ssl_result_format', $value);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\AuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function completeAuthorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\TransactionRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\TransactionRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\TransactionRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function void(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\VoidRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Converge\Message\GenerateTokenRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
//    public function updateCard(array $parameters = array())
//    {
//        return $this->createRequest('\Omnipay\Converge\Message\CardReferenceRequest', $parameters);
//    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
//    public function deleteCard(array $parameters = array())
//    {
//        return $this->createRequest('\Omnipay\Converge\Message\CardReferenceRequest', $parameters);
//    }
}
