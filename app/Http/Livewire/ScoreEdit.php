<?php

namespace App\Http\Livewire;

use Illuminate\Console\View\Components\Alert;
use Livewire\Component;
use PhpParser\Node\Stmt\For_;

class ScoreEdit extends Component
{
    public $result;
    public $homeScore;
    public $visitorScore;
    public $homeSet = [0, 0, 0, 0, 0];
    public $visitorSet = [0, 0, 0, 0, 0];
    public $editabled;

    public function mount()
    {
        $this->homeScore = $this->result->home_set_won;
        $this->visitorScore = $this->result->visitor_set_won;

        for ($i = 0; $i < 5; $i++) {
            $this->homeSet[$i] = $this->result->teams[0]->pivot['set_' . $i + 1];
            $this->visitorSet[$i] = $this->result->teams[1]->pivot['set_' . $i + 1];
        }

        $this->editabled = !$this->result->tournament->autosync;

        $this->scoreUpdate();
    }

    public function render()
    {
        return view('livewire.score-edit');
    }

    public function updated()
    {
        $home = 0;
        $visitor = 0;
        for ($i = 0; $i < 5; $i++) {
            $home += ($this->homeSet[$i] > $this->visitorSet[$i] ? 1 : 0);
            $visitor += ($this->visitorSet[$i] > $this->homeSet[$i] ? 1 : 0);
        }

        $this->homeScore = $home;
        $this->visitorScore = $visitor;
    }


    public function scoreUpdate()
    {
        // $home = 0;
        // $visitor = 0;
        // for ($i = 0; $i < 5; $i++) {
        //     $home += ($this->homeSet[$i] > $this->visitorSet[$i] ? 1 : 0);
        //     $visitor += ($this->visitorSet[$i] > $this->homeSet[$i] ? 1 : 0);
        // }

        // $this->homeScore = $home;
        // $this->visitorScore = $visitor;
    }
}
