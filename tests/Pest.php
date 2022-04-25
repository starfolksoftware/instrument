<?php

use Illuminate\Contracts\Auth\Authenticatable;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
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
