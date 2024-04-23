<x-app-layout>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="ms-3 text-center">
                {{ __('Update Support Ticket') }}
    </h2>
    <form method="POST" action="{{ route('ticket.update', $ticket->id) }}" enctype="multipart/form-data">
        @method('patch')
        @csrf

        <!-- Title -->
        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" value="{{$ticket->title}}" required autofocus />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <x-textarea class="block mt-1 w-full" id="description" name="description" value="{{$ticket->description}}" required rows="10"/>

            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Attachment -->
        <div class="mt-4">
        @if($ticket->attachment)
        <a style="color: blue; font-weight: bold;" target="_blank" href="{{'/storage/'.$ticket->attachment}}">Attachment</a>
        @endif
            <x-input-label for="attachment" :value="__('Attachment (If any)')" />
            <!-- <input type="file" name="attachment" id="attachment" :value="old('attachment')"/> -->
            <x-fileinput name="attachment" id="attachment" :value="old('attachment')"/>
            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-3">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
</x-app-layout>