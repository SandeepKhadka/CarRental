<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReferralLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $referralLink;

    public function __construct($referralLink)
    {
        $this->referralLink = $referralLink;
    }

    public function build()
    {
        return $this->subject('Your referral link')->view('mail.referral-link');
    }
}
