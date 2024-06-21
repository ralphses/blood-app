<?php

namespace App\Enums\Status;

enum DonationMatchStatus
{
    case DECLINED;
    case PENDING;
    case CONFIRMED;

}
