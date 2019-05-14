<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Exports\EventsExport;
use App\Exports\TicketsExport;
use Excel;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Event::with('tickets','user')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $event = new Event();

        $event->name = $request->name;

        $event->description = $request->description;
        $event->date = $request->date;

        $event->city = $request->city;
        $event->maximum = $request->maximum;
        // $event->image = $request->image;

        $event->user_id = $request->user;

        $event->save();

        return Event::with('user', 'tickets')->find($event->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Event::with('user', 'tickets')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export(Request $request){
        return Excel::download(new EventsExport($request->date), 'TicketsOn'.$request->date.'.xlsx');
    }
}
