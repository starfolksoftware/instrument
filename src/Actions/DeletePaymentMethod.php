<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Contracts\DeletesPaymentMethods;
use Instrument\Events\DeletingPaymentMethod;
use Instrument\Events\PaymentMethodDeleted;
use Instrument\PaymentMethod;

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
