<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Scandiweb\SamplePaymentGateway\Gateway\Request;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Scandiweb\SamplePaymentGateway\Gateway\Http\Client\ClientMock;

class MockDataRequest implements BuilderInterface
{
    const FORCE_RESULT = 'FORCE_RESULT';

    /**
     * Builds ENV request
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject): array
    {
        if (!isset($buildSubject['payment'])
            || !$buildSubject['payment'] instanceof PaymentDataObjectInterface
        ) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }

        $paymentDO = $buildSubject['payment'];
        $payment = $paymentDO->getPayment();

        $transactionResult = $payment->getAdditionalInformation('transaction_result');
        return [
            self::FORCE_RESULT => $transactionResult === null
                ? ClientMock::SUCCESS
                : $transactionResult
        ];
    }
}
