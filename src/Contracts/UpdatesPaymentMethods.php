<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\PaymentMethod;

interface UpdatesPaymentMethods
{
    /**
     * Update an existing payment method.
     */
    public function __invoke(Model $user, PaymentMethod $paymentMethod, array $data): PaymentMethod;
}
