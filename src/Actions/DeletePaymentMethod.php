<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\PaymentMethod;
use Instrument\Contracts\DeletesPaymentMethods;
use Instrument\Events\PaymentMethodDeleted;
use Instrument\Events\DeletingPaymentMethod;

class DeletePaymentMethod implements DeletesPaymentMethods
{
    /**
     * Delete a payment method.
     */
    public function __invoke(Model $user, PaymentMethod $paymentMethod): void
    {
        event(new DeletingPaymentMethod($user, paymentMethod: $paymentMethod));

        $paymentMethod->delete();

        event(new PaymentMethodDeleted(user: $user, paymentMethod: $paymentMethod));
    }
}
