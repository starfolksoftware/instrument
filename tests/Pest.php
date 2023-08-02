<?php

use Illuminate\Contracts\Auth\Authenticatable;
use StarfolkSoftware\Instrument\Tests\Mocks\Account;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\Tax;
use StarfolkSoftware\Instrument\Tests\Mocks\Transaction;
use StarfolkSoftware\Instrument\Tests\TestCase;

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
