<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ad;
use App\Models\Message;

class ContactForm extends Component
{
    public $adId;
    public $type = 'inquiry';
    public $senderName = '';
    public $senderPhone = '';
    public $senderEmail = '';
    public $message = '';
    public $offerAmount = null;
    public $showForm = false;
    public $success = false;

    protected $rules = [
        'senderName' => 'required|string|max:255',
        'senderPhone' => 'required|string|max:20',
        'senderEmail' => 'nullable|email|max:255',
        'message' => 'required|string|min:10',
        'offerAmount' => 'nullable|numeric|min:0',
    ];

    public function mount($adId, $type = 'inquiry')
    {
        $this->adId = $adId;
        $this->type = $type;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->success = false;
    }

    public function submit()
    {
        $this->validate();

        Message::create([
            'ad_id' => $this->adId,
            'sender_id' => auth()->id(),
            'sender_name' => $this->senderName,
            'sender_phone' => $this->senderPhone,
            'sender_email' => $this->senderEmail,
            'message' => $this->message,
            'type' => $this->type,
            'offer_amount' => $this->offerAmount,
            'status' => 'new',
        ]);

        $this->reset(['senderName', 'senderPhone', 'senderEmail', 'message', 'offerAmount']);
        $this->success = true;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
