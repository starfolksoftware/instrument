<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Contracts\UpdatesPaymentMethods;
use Instrument\Events\PaymentMethodUpdated;
use Instrument\Events\UpdatingPaymentMethod;
use Instrument\PaymentMethod;

class UpdatePaymentMethod implements UpdatesPaymentMethods
{
    /**
     * Update an existing payment method.
     */
    public function __invoke(Model $user, PaymentMethod $paymentMethod, array $data): PaymentMethod
    {
        event(new UpdatingPaymentMethod(user: $user, paymentMethod: $paymentMethod, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'meta' => 'nullable|array',
        ])->validateWithBag('updatePaymentMethod');

        $paymentMethod->update(collect($data)->only([
            'name',
            'meta',
        ])->toArray());

        event(new PaymentMethodUpdated(user: $user, paymentMethod: $paymentMethod, data: $data));

        return $paymentMethod->refresh();
    }
}
