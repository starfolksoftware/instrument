<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\PaymentMethod;
use Instrument\Contracts\CreatesPaymentMethods;
use Instrument\Events\PaymentMethodCreated;
use Instrument\Events\CreatingPaymentMethod;
use Instrument\Instrument;

class CreatePaymentMethod implements CreatesPaymentMethods
{
    /**
     * Create a new paymentMethod.
     */
    public function __invoke(Model $user, array $data, $teamId = null): PaymentMethod
    {
        event(new CreatingPaymentMethod(user: $user, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'meta' => 'nullable|array',
        ])->validateWithBag('createPaymentMethod');

        $fields = collect($data)->only([
            'name',
            'meta',
        ])->toArray();

        $paymentMethod = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->paymentMethods()->create($fields) :
            Instrument::newPaymentMethodModel()->create($fields);

        event(new PaymentMethodCreated(user: $user, paymentMethod: $paymentMethod, data: $data));

        return $paymentMethod;
    }
}
