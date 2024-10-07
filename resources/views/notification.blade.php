<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mt-6">
                    <table class="table-auto w-full text-center">
                        <thead>
                            <tr class="bg-gray-200">
                                <th scope="col" class="px-4 py-2">Id</th>
                                <th scope="col" class="px-4 py-2">Message</th>
                                <th scope="col" class="px-4 py-2">Received At</th>
                                <th scope="col" class="px-4 py-2">Read At</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($notifications->count() > 0)
                            @foreach ($notifications as $notification)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $notification->data['message'] }}</td>
                                    <td class="border px-4 py-2">{{ $notification->created_at->diffForHumans() }}</td>
                                    <td class="border px-4 py-2">{{ $notification->read_at?->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        
                            <!-- Pagination links -->
                            <tr>
                                <td colspan="4">
                                    {{ $notifications->links() }}
                                </td>
                            </tr>
                        @endif
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
