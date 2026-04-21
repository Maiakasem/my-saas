<?php

use App\Models\Talk;
use App\Models\User;

test('talks index page is displayed for authenticated user', function () {
    $user = User::factory()->create();
    $talks = Talk::factory(3)->for($user)->create();

    $response = $this
        ->actingAs($user)
        ->get('/talks/index');

    $response->assertOk();
    $response->assertViewHas('talks', function ($viewTalks) use ($talks) {
        return $viewTalks->count() === $talks->count();
    });
});

test('talks index shows empty state when no talks exist', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/talks/index');

    $response->assertOk();
    $response->assertSee('No talks yet');
});

test('unauthenticated user cannot view talks index', function () {
    $response = $this->get('/talks/index');

    $response->assertRedirect('/login');
});

test('user can only see their own talks', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $talk1 = Talk::factory()->for($user1)->create(['title' => 'My Talk']);
    $talk2 = Talk::factory()->for($user2)->create(['title' => 'Other Talk']);

    $response = $this
        ->actingAs($user1)
        ->get('/talks/index');

    $response->assertSee('My Talk');
    $response->assertDontSee('Other Talk');
});

test('create talk form is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/talks/create');

    $response->assertOk();
    $response->assertSee('Add Talk');
});

test('unauthenticated user cannot view create talk form', function () {
    $response = $this->get('/talks/create');

    $response->assertRedirect('/login');
});

test('talk can be created with valid data', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/talks', [
            'title' => 'Test Talk',
            'length' => '45 min',
            'type' => 'keynote',
            'abstract' => 'This is a test talk about testing.',
            'organizer_notes' => 'Please arrange for a projector.',
        ]);

    $response->assertRedirect('/talks/index');
    $response->assertSessionHas('success', 'Talk created successfully.');

    $this->assertDatabaseHas('talks', [
        'title' => 'Test Talk',
        'user_id' => $user->id,
        'type' => 'keynote',
    ]);
});

test('talk cannot be created without required fields', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/talks', [
            'title' => '',
            'length' => '',
            'type' => '',
            'abstract' => '',
        ]);

    $response->assertSessionHasErrors(['title', 'length', 'type', 'abstract']);
});

test('talk cannot be created with invalid type', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/talks', [
            'title' => 'Test Talk',
            'length' => '45 min',
            'type' => 'invalid_type',
            'abstract' => 'This is a test talk.',
        ]);

    $response->assertSessionHasErrors('type');
});

test('edit talk form is displayed for talk owner', function () {
    $user = User::factory()->create();
    $talk = Talk::factory()->for($user)->create();

    $response = $this
        ->actingAs($user)
        ->get("/talks/{$talk->id}/edit");

    $response->assertOk();
    $response->assertSee($talk->title);
});

test('talk can be updated with valid data', function () {
    $user = User::factory()->create();
    $talk = Talk::factory()->for($user)->create([
        'title' => 'Old Title',
        'abstract' => 'Old abstract',
    ]);

    $response = $this
        ->actingAs($user)
        ->patch("/talks/{$talk->id}", [
            'title' => 'New Title',
            'length' => '60 min',
            'type' => 'lightting',
            'abstract' => 'New abstract',
            'organizer_notes' => 'Updated notes',
        ]);

    $response->assertRedirect('/talks/index');
    $response->assertSessionHas('success', 'Talk updated successfully.');

    $this->assertDatabaseHas('talks', [
        'id' => $talk->id,
        'title' => 'New Title',
        'abstract' => 'New abstract',
    ]);
});

test('talk can be deleted by owner', function () {
    $user = User::factory()->create();
    $talk = Talk::factory()->for($user)->create();

    $response = $this
        ->actingAs($user)
        ->delete("/talks/{$talk->id}");

    $response->assertRedirect('/talks/index');
    $response->assertSessionHas('success', 'Talk deleted successfully.');

    $this->assertDatabaseMissing('talks', [
        'id' => $talk->id,
    ]);
});

test('all enum talk types can be created', function () {
    $user = User::factory()->create();

    $types = ['lightting', 'standrad', 'keynote'];

    foreach ($types as $type) {
        $response = $this
            ->actingAs($user)
            ->post('/talks', [
                'title' => "Talk about {$type}",
                'length' => '45 min',
                'type' => $type,
                'abstract' => 'Test abstract',
            ]);

        $response->assertRedirect('/talks/index');
        $this->assertDatabaseHas('talks', [
            'type' => $type,
        ]);
    }
});

test('organizer notes is optional', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/talks', [
            'title' => 'Test Talk',
            'length' => '45 min',
            'type' => 'keynote',
            'abstract' => 'Test abstract',
            'organizer_notes' => '',
        ]);

    $response->assertRedirect('/talks/index');
    $this->assertDatabaseHas('talks', [
        'title' => 'Test Talk',
    ]);
});
