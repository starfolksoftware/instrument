<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Instrument\Tests\Mocks\Account;
use Instrument\Tests\Mocks\Contact;
use Instrument\Tests\Mocks\Currency;
use Instrument\Tests\Mocks\Document;
use Instrument\Tests\Mocks\PaymentMethod;
use Instrument\Tests\Mocks\Report;
use Instrument\Tests\Mocks\Tax;
use Instrument\Tests\Mocks\Transaction;
use Instrument\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/**
 * Set the currently logged in user for the application.
 *
 * @return TestCase
 */
function actingAs(Authenticatable $user, string $driver = null)
{
    return test()->actingAs($user, $driver);
}

/**
 * Returns document fields.
 *
 * @return array
 */
function documentFields()
{
    return Document::factory()->raw();
}

/**
 * Returns account fields.
 *
 * @return array
 */
function accountFields()
{
    return Account::factory()->raw();
}

/**
 * Returns transaction fields.
 *
 * @return array
 */
function transactionFields()
{
    return Transaction::factory()->raw();
}

/**
 * Returns tax fields.
 *
 * @return array
 */
function taxFields()
{
    return Tax::factory()->raw();
}

/**
 * Returns contact fields.
 *
 * @return array
 */
function contactFields()
{
    return Contact::factory()->raw();
}

/**
 * Returns currency fields.
 *
 * @return array
 */
function currencyFields()
{
    return Currency::factory()->raw();
}

/**
 * Returns payment method fields.
 * 
 * @return array
 */
function paymentMethodFields()
{
    return PaymentMethod::factory()->raw();
}

/**
 * Returns report fields.
 * 
 * @return array
 */
function reportFields()
{
    return Report::factory()->raw();
}
