<?php

use App\Models\Company;
use App\Models\User;
use App\Notifications\AttachmentProcessed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Nonstandard\Uuid;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->user = User::factory()->create([
        'company_id' => $this->company->id
    ]);
    actingAs($this->user);

    $this->user->notify(new AttachmentProcessed([
        'message' => 'Test',
    ]));
    $this->user->notify(new AttachmentProcessed([
        'message' => 'test 2',
    ]));
});

it('marks a single notification as read', function () {
    $notification = $this->user->notifications->first();

    post(route('notifications.read', $notification->id))
        ->assertRedirectBack()
        ->assertSessionHasNoErrors();

    $this->assertNotNull($notification->fresh()->read_at);
});

it('marks all notifications as read', function () {
    post(route('notifications.readAll'))
        ->assertRedirectBack()
        ->assertSessionHasNoErrors();

    foreach ($this->user->notifications as $notification) {
        $this->assertNotNull($notification->fresh()->read_at);
    }
});

it('returns 404 if notification does not exist', function () {
    $invalidId = Uuid::uuid4()->toString();

    post(route('notifications.read', $invalidId))
        ->assertRedirectBack()
        ->assertSessionHas('error', 'Notification not found');
});
