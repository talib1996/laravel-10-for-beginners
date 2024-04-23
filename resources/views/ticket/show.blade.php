<x-app-layout>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <p class="w-full ms-3 text-center text-xl">
                {{ __('Ticket #') }}{{$ticket->id}}
</p>
    <h1 class="text-lg font-bold"><span>Title: </span>{{ $ticket->title }}</h1>
        <p><span class="text-lg font-bold">Description: </span>{{$ticket->description}}</p>
        <p><span class="text-lg font-bold">Created At: </span>{{$ticket->created_at->diffForHumans()}}</p>
        @if($ticket->attachment)
        <a style="color: blue; font-weight: bold;" target="_blank" href="{{'/storage/'.$ticket->attachment}}">Attachment</a>
        @endif
        <div class="flex justify-between mt-2">
            <div class="flex justify justify-start">
                <form action="{{route('ticket.edit', $ticket->id)}}" method="get">
                    <x-primary-button href="">Edit</x-primary-button>
                </form>
                <form class="ms-2" action="{{route('ticket.destroy', $ticket->id)}}" method="post">
                    @method('delete')
                    @csrf
                    <x-primary-button>Delete</x-primary-button>
                </form>
            </div>
            @if(auth()->user()->isAdmin)
            <div class="flex justify-end">
                <form action="{{ route('ticket.update', $ticket->id) }}" method="post">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="status" value="resolved"/>
                    <x-primary-button>Approve</x-primary-button>
                </form>
                <form action="{{ route('ticket.update', $ticket->id) }}" method="post">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="status" value="rejected"/>
                    <x-primary-button type="submit" class="ms-2">Reject</x-primary-button>
                </form>
            </div>
            @else
            <p> Status: {{$ticket->status}}</p>
            @endif
        </div>
</x-guest-layout>
</x-app-layout>