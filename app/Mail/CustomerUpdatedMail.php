<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\CustomerCatalogue;

class CustomerUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Customer $customer;
    public CustomerCatalogue $newCatalogue;

    public function __construct(Customer $customer, CustomerCatalogue $newCatalogue)
    {
        $this->customer = $customer;
        $this->newCatalogue = $newCatalogue;
    }

    public function build()
    {
        return $this->subject('Thông báo cập nhật loại cộng tác viên')
                    ->view('mail.customer_updated')
                    ->with([
                        'customer' => $this->customer,
                        'newCatalogue' => $this->newCatalogue
                    ]);
    }
}
