<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\PaymentMethod;

interface CreatesPaymentMethods
{
    /**
     * Create a new account.
     */
    public function __invoke(Model $user, array $data, $teamId = null): PaymentMethod;
}
