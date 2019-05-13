<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        while($request->count > 0){
            $ticket = new Ticket();
            $ticket->user_id = $request->user;
            $ticket->event_id = $request->event;
            $ticket->is_used = 0;
            $ticket->save();

            $request->count--;
        }


        return $ticket;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        // return $id;
        $ticket = Ticket::find($id);
        $delete = $ticket->delete();
        return "success";
    }

    public function myTickets(Request $request){
        // return response()->json(['id'=>$request->id]);
        $tickets = Ticket::with('event','event.user','event.tickets')->where('user_id','=',$request->id)->get();
        return $tickets;
    }

    public function hasJoined(Request $request){
        // return "hi";
        // return response()->json($request->event);
        $check = Ticket::where('event_id','=', $request->event)->where('user_id','=',$request->user)->first();
        $check = $check === null;
        if(!$check){
            return response()->json(['hasJoined'=>true]);
        }
            return response()->json(['hasJoined'=>false]);
    }
}
