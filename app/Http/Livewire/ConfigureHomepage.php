<?php

namespace App\Http\Livewire;

use Hamcrest\Core\Set;
use Livewire\Component;
use App\Models\Setting;
use App\Models\Notice;

class ConfigureHomepage extends Component
{
    public $showCarousel;
    public $showNotice;
    public $notice;
    public $noticeTitle;
    public $noticeSubtitle;
    public $noticeIcon;
    public $noticeBackgroundColor;
    public $noticeColor;

    public function mount()
    {
        $this->showCarousel = (bool)Setting::valueForKey('show_carousel', false);
        $this->showNotice = (bool)Setting::valueForKey('show_notice', false);

        $this->notice = Notice::find(1);

        $this->noticeTitle = $this->notice->title;
        $this->noticeSubtitle = $this->notice->subtitle;
        $this->noticeIcon = $this->notice->icon;
        $this->noticeBackgroundColor = $this->notice->background_color;
        $this->noticeColor = $this->notice->color;

    }

    public function render()
    {
        return view('livewire.configure-homepage');
    }

    public function updateAlert()
    {
        Setting::setValueForKey('show_notice', $this->showNotice);
    }

    public function updateCarousel()
    {
        Setting::setValueForKey('show_carousel', $this->showCarousel);
    }

    public function saveNotice()
    {
        // Aggiorno la notifica
        $this->notice->update([
            'title' => $this->noticeTitle,
            'subtitle' => $this->noticeSubtitle,
            'icon' => $this->noticeIcon,
            'background_color' => $this->noticeBackgroundColor,
        ]);
    }
}
