<?php

namespace App\Exports;

use App\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class EventsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        return Event::whereDate('date','=', Carbon::parse($this->date))->get();
    }
}
