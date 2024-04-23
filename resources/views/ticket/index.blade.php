<x-app-layout>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex justify-between">
        <h2 class="text-xl">Support Tickets</h2>
        <x-primary-anchor href="{{route('ticket.create')}}">Create New</x-primary-anchor>
    </div>
    <p class="w-full ms-3 text-center text-xl">
                    {{ __('Ticket List') }}
    </p>

            @forelse ($tickets as $ticket)
                <div class="flex justify-between py-4">
                    <a href="{{ route('ticket.show', $ticket->id) }}">{{ $ticket->title }}</a>
                    <p>{{ $ticket->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-center">You don't have any support ticket yet.</p>
            @endforelse
</x-guest-layout>
</x-app-layout>