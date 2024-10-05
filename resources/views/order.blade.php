<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
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
                                <th scope="col" class="px-4 py-2">User</th>
                                <th scope="col" class="px-4 py-2">Product Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="border px-4 py-2">{{ $order->user?->name }}</td>
                                    <td class="border px-4 py-2">{{ $order->orderItems()?->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
