<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

/**
 *  - Given: An empty users table
 *  - When: A post is sent to create an account
 *  - Then:
 *      - Create a new user
 *      - Return to the users/{username} page
 */
it('creates a new user', function ($username, $email) {

    $this->post('/users', [ 'username' => $username, 'email' => $email])
       ->assertRedirect();

    $this->assertDatabaseCount('users', 1);

    $this->assertDatabaseHas('users', [
       'username' => $username,
       'email' =>  $email
    ]);

    $this->get('/'.$username)
        ->assertSuccessful()
        ->assertSee($username)
        ->assertSee($email);

})->with('users_make')->group('users');

/**
 *  - Given: A list of forbidden username is provided
 *  - When: A post is sent to create an account
 *  - Then:
 *      - Returns a validation error
 */
it('avoid to create a new user with a forbidden username', function ($username, $email) {
    $this->post('/users', [ 'username' => $username, 'email' => $email])
        ->assertSessionHasErrors([
        'username' => 'You cannot use this username because it is already taken by the system'
    ]);
})->with('forbidden_usernames')->group('users');

/**
 *  - Given: A saved user
 *  - When: Access the /users/{username} page
 *  - Then:
 *      - Returns the saved user
 */
it('shows an user by username', function() {
    $user = User::factory()->create();

    $this->get('/'.$user->username)
        ->assertSuccessful()
        ->assertSee($user->username)
        ->assertSee($user->email);
})->group('users');

/**
 * Given: A list of 3 users with 6 products each
 *
 * When: I use the scope orderByProductsTotalValue
 *
 * Then: Returns a list of users ordered by product total value
 */
test('a query scope that returns the total price value of all products belonging to each user', function () {

    $orderedUsers = getUsersAndProductOrdered();

    $users = User::orderByProductsTotalValue()->get();

    assertUserList($users, $orderedUsers);
})->group('users');

/**
 * Given: A list of 3 users with 6 products each
 *
 * When: I use the scope orderByProductsTotalValue
 *
 * Then: Returns a list of users ordered by product total value and saves the data on Cache
 */
test('a method that will return data from cache or make a database call on expiration/missing', function () {
    $orderedUsers = getUsersAndProductOrdered();

    Cache::forget('orderByProductsTotalValueFromCache');

    $users = User::orderByProductsTotalValueFromCache()->get();

    $this->assertTrue(Cache::has('orderByProductsTotalValueFromCache'));

    assertUserList($users, $orderedUsers);

})->group('users');

function assertUserList($users, $orderedUsers) {

    expect($users[0]->id)->toBe($orderedUsers[0]['user']->id);
    expect($users[0]->total_price_products)->toBe($orderedUsers[0]['total']);

    expect($users[1]->id)->toBe($orderedUsers[1]['user']->id);
    expect($users[1]->total_price_products)->toBe($orderedUsers[1]['total']);

    expect($users[2]->id)->toBe($orderedUsers[2]['user']->id);
    expect($users[2]->total_price_products)->toBe($orderedUsers[2]['total']);

}
