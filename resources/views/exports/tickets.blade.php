<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th> Date </th>
            <th> City </th>
            <th> Tickets Left </th>
            <th> Coordinator </th>
        </tr>
        </thead>
        <tbody>

        @foreach($events as $event)
            <tr>
                <td>{{ $event->name }}</td>
                <td>{{ $event->description }}</td>
                <td>{{ $event->date }}</td>
                <td>{{ $event->city }}</td>
                <td> {{ $event->maximum - $event->tickets()->count() }} </td>
                <td> {{$event->user->name}} </td>
            </tr>
            <tr>
                <th> {{$event->tickets()->count()}} Tickets </th>
            </tr>
            <tr>
                <th>Name</th>
                <th> Bought on </th>
            </tr>
            @foreach($event['tickets'] as $ticket)

            <tr>
                <td> {{$ticket->user->name}} </td>
                <td> {{$ticket->created_at}} </td>
            </tr>

            @endforeach
        @endforeach
        </tbody>
    </table>

</html>
