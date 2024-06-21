<?php

namespace App\Enums\Status;

enum DonationStatus
{
    case PENDING;
    case CREATED;
    case COMPLETED;
    case CANCELED;
}
