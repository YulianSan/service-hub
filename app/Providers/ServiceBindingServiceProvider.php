<?php

namespace App\Providers;

use App\Contracts\Services\TicketAttachmentServiceInterface;
use App\Services\TicketAttachmentService;
use Illuminate\Support\ServiceProvider;

class ServiceBindingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TicketAttachmentServiceInterface::class,
            TicketAttachmentService::class
        );
    }

    public function boot(): void
    {
    }
}
