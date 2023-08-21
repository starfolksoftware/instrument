<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\PaymentMethod;

interface DeletesPaymentMethods
{
    /**
     * Delete an existing payment method.
     */
    public function __invoke(Model $user, PaymentMethod $paymentMethod): void;
}
