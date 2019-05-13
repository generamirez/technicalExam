<?php

namespace App\Exports;

use App\Ticket;
use App\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class TicketsExport implements FromCollection
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
        // $tickets = Ticket::with(array('event'=>function($query){
        //     $query->select('id','date');
        // }))->where("date",'=',Carbon::parse($this->date))->get();
        // dd(Event::with('tickets')->whereDate('date','=', Carbon::parse($this->date))->get());
        // dd(Ticket::with('event')->whereDate(event.date,'=', Carbon::parse($this->date))->get());
        return Ticket::with('event')->whereDate('event.date','=', Carbon::parse($this->date))->get();
    }
}
