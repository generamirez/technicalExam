<?php

namespace App\Exports;

use App\Event;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class EventsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        // dd(Event::query()->with('tickets')->whereDate('date','=', Carbon::parse($this->date))->get());
        // return Event::with('tickets')->whereDate('date','=', Carbon::parse($this->date))->get();
        return view('exports.tickets', [
            'events' => Event::with('tickets', 'user')->whereDate('date','=', Carbon::parse($this->date))->get()
        ]);
    }
}
