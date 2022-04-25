<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Events\AccountCreated;
use StarfolkSoftware\Instrument\Events\AccountDeleted;
use StarfolkSoftware\Instrument\Events\AccountUpdated;
use StarfolkSoftware\Instrument\Events\CreatingAccount;
use StarfolkSoftware\Instrument\Events\DeletingAccount;
use StarfolkSoftware\Instrument\Events\UpdatingAccount;
use StarfolkSoftware\Instrument\Tests\Mocks\Account;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useAccountModel(Account::class);
});

test('account can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('accounts.store'), accountFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingAccount::class);
    Event::assertDispatched(AccountCreated::class);

    expect(Account::count())->toBe(1);
});

test('account can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $account = Account::factory()->create();

    $fields = accountFields();

    $response = actingAs($user)->put(route('accounts.update', $account), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingAccount::class);
    Event::assertDispatched(AccountUpdated::class);

    $this->assertDatabaseHas('accounts', [
        'name' => $fields['name'],
        'number' => $fields['number'],
    ]);
});

test('account can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $account = Account::factory()->create();

    $response = actingAs($user)->delete(route('accounts.destroy', $account), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingAccount::class);
    Event::assertDispatched(AccountDeleted::class);

    expect(Account::count())->toEqual(0);
});
