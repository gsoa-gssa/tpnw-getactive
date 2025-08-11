<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventGrid extends Component
{
    public $events;
    public $filters = [];
    public $eventCounter = 0;
    public $selectedEvents = [];
    public $cantons = [];

    public function mount($events)
    {
        $this->events = $events;
        $this->cantons = Event::whereDate('date', '>=', now())
            ->where('visibility', true)
            ->pluck('canton')
            ->unique()
            ->values()
            ->all();
    }

    public function changeFilter($filter, $value)
    {
        if ($value == "all") {
            unset($this->filters[$filter]);
        } else {
            $this->filters[$filter] = $value;
        }
        $this->filterEvents();
    }

    public function filterEvents()
    {
        $query = Event::query();
        if (isset($this->filters["type"])) {
            $query->where("type", $this->filters["type"]);
        }
        if (isset($this->filters["canton"])) {
            $query->where(function ($query) {
                $query->where("canton", $this->filters["canton"])
                    ->orWhere("canton", "national");
            });
        }
        $query->whereDate('date', ">=", now())->where("visibility", true)->orderBy('date', 'asc')->get();
        $this->events = $query->get();
    }

    public function changeCounter($checked) {
        if ($checked) {
            $this->eventCounter++;
        } else {
            $this->eventCounter--;
        }
    }

    public function render()
    {
        return view('livewire.event-grid');
    }
}
