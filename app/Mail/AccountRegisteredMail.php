<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $password;

    public function __construct($customer,$password)
    {
        $this->customer = $customer;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Chào mừng bạn đến với hệ thống')
                    ->view('mail.account_registered')
                    ->with(['customer' => $this->customer,
                            'password' => $this->password]);
    }
}
