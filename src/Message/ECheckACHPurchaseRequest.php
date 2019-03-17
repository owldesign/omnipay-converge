<?php
namespace Omnipay\Converge\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * Converge ECheck/ACH Purchase Request
 *
 * The ecspurchase is a transaction in which money is debited from
 * a checking account using a check. Data is either captured manually
 * (ACH ECheck : WEB, TEL, PPD, CCD) or from a paper check (ECS Paper Conversion:
 * POP, BOC and ARC) using a check reader device.
 */
class ECheckACHPurchaseRequest extends AbstractRequest
{
  protected $transactionType = 'ecspurchase';

  public function getData() {
    $data = array(
      'ssl_transaction_type'    => $this->transactionType,
      'ssl_amount'              => $this->getAmount(),
      'ssl_aba_number'          => $this->getParameter('ssl_aba_number'),
      'ssl_bank_account_number' => $this->getParameter('ssl_bank_account_number'),
      'ssl_bank_account_type'   => $this->getParameter('ssl_bank_account_type'),
      'ssl_agree'               => $this->getParameter('ssl_agree'),
      'ssl_first_name'          => $this->getParameter('ssl_first_name'),
      'ssl_last_name'           => $this->getParameter('ssl_last_name'),
      'ssl_company'             => $this->getParameter('ssl_company'),
    );

    $data = array_merge($this->getBaseData(), $data);

    return $data;
  }
}
