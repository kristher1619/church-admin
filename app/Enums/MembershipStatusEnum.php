<?php

namespace App\Enums;

enum MembershipStatusEnum: string
{
    use HasValuesTrait;

    case Professing = 'Professing';
    case Baptized = 'Baptized';
    case Affiliate = 'Affiliate Member';
    case WithdrawnDeath = 'Withdrawn - Death';
    case WithdrawnTransferred = 'Withdrawn - Transferred';
    case WithdrawnAccepted = 'Withdrawn - Accepted';


}
