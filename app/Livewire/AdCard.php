<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ad;

class AdCard extends Component
{
    // أزلنا النوع "Ad" من هنا لمنع تعارض stdClass
    public $ad; 

    public function mount($ad)
    {
        // نتحقق إذا كان ما وصل هو رقم معرف (ID) أو كائن
        $this->ad = $ad;
    }

    public function render()
    {
        return view('livewire.ad-card');
    }
}