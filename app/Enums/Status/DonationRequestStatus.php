<?php

namespace App\Enums\Status;

enum DonationRequestStatus
{
    case PENDING;
    case COMPLETED;
    case CANCELED;
    case MATCHED;
}
