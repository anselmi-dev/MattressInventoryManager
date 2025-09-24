<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\Email\{
    EmailSent,
    EmailViewed,
    EmailLinkClicked,
    EmailDelivered,
    EmailComplaint,
    BouncedEmail,
};

use jdavidbakr\MailTracker\Events\{
    EmailSentEvent,
    ViewEmailEvent,
    LinkClickedEvent,
    EmailDeliveredEvent,
    ComplaintMessageEvent,
    PermanentBouncedMessageEvent,
};

use App\Events\ProductCreated;
use App\Listeners\Product\InitializeProductStock;
use App\Listeners\Product\AssociateProductType;
use App\Listeners\Product\AssociateDimensionProduct;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        EmailSentEvent::class => [
            EmailSent::class,
        ],
        ViewEmailEvent::class => [
            EmailViewed::class,
        ],
        LinkClickedEvent::class => [
            EmailLinkClicked::class,
        ],
        EmailDeliveredEvent::class => [
            EmailDelivered::class,
        ],
        ComplaintMessageEvent::class => [
            EmailComplaint::class,
        ],
        PermanentBouncedMessageEvent::class => [
            BouncedEmail::class,
        ],
        ProductCreated::class => [
            InitializeProductStock::class,
            AssociateProductType::class,
            AssociateDimensionProduct::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
