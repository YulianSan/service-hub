<?php

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

use App\Enums\TicketStatus;
use App\Models\Attachment;
use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {

    $this->company = Company::factory()->create();

    $this->user = User::factory()->create([
        'company_id' => $this->company->id
    ]);

    actingAs($this->user);

    $this->project = Project::factory()->create([
        'company_id' => $this->company->id
    ]);
});

it('lists tickets', function () {
    Ticket::factory()
        ->count(3)
        ->create([
            'project_id' => $this->project->id,
            'user_id' => $this->user->id
        ]);

    $response = get(route('tickets.index'));

    $response->assertStatus(200);

    $response->assertInertia(
        fn($page) =>
        $page->component('Ticket/Index')
            ->has('tickets.data', 3)
    );
});

it('shows create page', function () {

    $response = get(route('tickets.create'));

    $response->assertStatus(200);

    $response->assertInertia(
        fn($page) =>
        $page->component('Ticket/CreateEdit')
    );
});

it('creates ticket', function () {

    $data = [
        'title' => 'Test Ticket',
        'project_id' => $this->project->id
    ];

    $response = post(route('tickets.store'), $data);

    $response->assertRedirect(route('tickets.index'));

    $this->assertDatabaseHas('tickets', [
        'title' => 'Test Ticket'
    ]);

    $this->assertDatabaseHas('tickets', [
        'title' => 'Test Ticket',
        'project_id' => $this->project->id,
        'status' => TicketStatus::OPEN,
        'user_id' => $this->user->id
    ]);
});

it('shows edit page', function () {

    $ticket = Ticket::factory()->create([
        'project_id' => $this->project->id,
        'user_id' => $this->user->id
    ]);

    $response = get(route('tickets.edit', $ticket));

    $response->assertStatus(200);

    $response->assertInertia(
        fn($page) =>
        $page->component('Ticket/CreateEdit')
            ->where('ticket.id', $ticket->id)
    );
});

it('updates ticket', function () {
    $ticket = Ticket::factory()->create([
        'project_id' => $this->project->id,
        'user_id' => $this->user->id
    ]);

    $response = put(route('tickets.update', $ticket), [
        'title' => 'Updated Ticket'
    ]);

    $response->assertRedirect(route('tickets.index'));

    $this->assertDatabaseHas('tickets', [
        'id' => $ticket->id,
        'title' => 'Updated Ticket'
    ]);
});

it('deletes ticket', function () {

    $ticket = Ticket::factory()->create([
        'project_id' => $this->project->id,
        'user_id' => $this->user->id
    ]);

    $response = delete(route('tickets.destroy', $ticket));

    $response->assertRedirect(route('tickets.index'));

    $this->assertDatabaseMissing('tickets', [
        'id' => $ticket->id
    ]);
});

it('does not list tickets from another company', function () {

    $otherCompany = Company::factory()->create();

    $otherProject = Project::factory()->create([
        'company_id' => $otherCompany->id
    ]);

    $otherUser = User::factory()->create([
        'company_id' => $otherCompany->id
    ]);

    $ticket = Ticket::factory()->create([
        'project_id' => $otherProject->id,
        'user_id' => $otherUser->id
    ]);

    $response = get(route('tickets.index'));

    $response->assertInertia(
        fn($page) =>
        $page->has('tickets.data', 0)
    );

    $response = get(route('tickets.edit', $ticket->id));
    $response->assertForbidden();

    $response = put(route('tickets.update', $ticket->id), [
        'title' => 'Updated Ticket'
    ]);
    $response->assertForbidden();

    $response = delete(route('tickets.destroy', $ticket->id));
    $response->assertForbidden();
});

it('creates ticket with attachment', function () {
    Bus::fake();
    Storage::fake();

    $file = UploadedFile::fake()->create('test.txt', 10, 'text/plain');

    $response = post(route('tickets.store'), [
        'project_id' => $this->project->id,
        'title' => 'Ticket with attachment',
        'attachment' => $file
    ]);

    $response->assertRedirect(route('tickets.index'));

    $ticket = Ticket::first();

    expect($ticket)->not->toBeNull();

    expect($ticket->status)
        ->toBe(TicketStatus::PENDING_ATTACHMENT_PROCESSING);

    $attachment = Attachment::first();

    expect($attachment)->not->toBeNull();

    expect($attachment->attachable_id)
        ->toBe($ticket->id);

    Storage::assertExists($attachment->path);
});

it('updates a ticket via controller and replaces attachment', function () {
    Storage::fake();
    Bus::fake();

    $initialFile = UploadedFile::fake()->create('initial.txt', 10, 'text/plain');

    $ticket = Ticket::factory()->create([
        'title' => 'Initial Ticket',
        'project_id' => $this->project->id,
        'user_id' => $this->user->id,
        'status' => TicketStatus::OPEN
    ]);

    $filename = 'initial.txt';
    $path = Storage::putFileAs('attachments', $initialFile, $filename);

    $ticket->attachment()->create([
        'filename' => $filename,
        'path' => $path,
        'mime_type' => 'txt',
        'size' => $initialFile->getSize()
    ]);

    $initialAttachmentPath = $path;

    $newFile = UploadedFile::fake()->create('new.txt', 15, 'text/plain');

    $response = $this->put(route('tickets.update', $ticket), [
        'title' => 'Updated Ticket',
        'attachment' => $newFile
    ]);

    $response->assertRedirect(route('tickets.index'));

    $ticket->refresh();

    expect($ticket->title)->toBe('Updated Ticket');

    expect($ticket->status)->toBe(TicketStatus::PENDING_ATTACHMENT_PROCESSING);

    assertDatabaseMissing('attachments', [
        'path' => $initialAttachmentPath
    ]);

    Storage::assertMissing($initialAttachmentPath);

    $newAttachment = $ticket->attachment;
    expect($newAttachment)->not->toBeNull();
    Storage::assertExists($newAttachment->path);

    assertDatabaseHas('attachments', [
        'path' => $newAttachment->path,
        'attachable_id' => $ticket->id,
        'attachable_type' => Ticket::class,
        'size' => $newFile->getSize(),
    ]);
});
