<?php

namespace App\Enums;

enum Status
{
    case PENDING;
    case COMPLETED;
    case MATCHED;
    case CANCELED;
    case CONFIRMED;
    case DECLINED;
    case SCHEDULED;
}
