<?php

namespace Ysfkaya\NovaFeedback\Interfaces;

interface Status
{
    const WAITING_RESPONSE = 'WAITING_RESPONSE';

    const SOLVED = 'SOLVED';

    const ANSWERED = 'ANSWERED';

    const WAITING_APPROVAL = 'waiting_approval';

    const PRICED = 'PRICED';

    const WAITING_PRICING= 'WAITING_PRICING';

    const APPROVED = 'APPROVED';

    const UNAPPROVED = 'UNAPPROVED';

    const IN_PROGRESS = 'IN_PROGRESS';

}