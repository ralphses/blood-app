<?php

namespace App\Enums\Status;

enum DonationAppointmentStatus
{
    case CREATED;
    case REQUESTED;
    case COMPLETED;
    case CANCELED;
    case SCHEDULED;
}
