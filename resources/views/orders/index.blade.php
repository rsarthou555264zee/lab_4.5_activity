<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orders Listing
        </h2>
    </x-slot>

    <div style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b text-xs uppercase text-gray-600 font-semibold">
                                <th class="p-3">Order Number</th>
                                <th class="p-3">Customer</th>
                                <th class="p-3">Staff Member</th>
                                <th class="p-3">Total Amount</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-medium text-gray-900">{{ $order->order_number }}</td>
                                    <td class="p-3 text-gray-700">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                                    <td class="p-3 text-gray-700">{{ $order->user->name }}</td>
                                    <td class="p-3 font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>