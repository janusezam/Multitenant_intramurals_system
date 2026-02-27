@extends('layouts.admin')
@section('title', 'Subscriptions')

<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Subscriptions</h1>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">University</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Academic Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Starts At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Expires At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Amount Paid</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Days Remaining</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($subscriptions as $subscription)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900">{{ $subscription->university->name }}</span>
                                    @if($subscription->university->plan === 'pro')
                                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">PRO</span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">BASIC</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $subscription->academic_year }}</td>
                            <td class="px-6 py-4">
                                @if($subscription->plan === 'pro')
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">PRO</span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">BASIC</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $subscription->starts_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                @if($subscription->expires_at->isPast())
                                    <span class="text-red-600 font-semibold">{{ $subscription->expires_at->format('M d, Y') }}</span>
                                @elseif($subscription->expires_at->diffInDays(now()) <= 30)
                                    <span class="text-yellow-600 font-semibold">{{ $subscription->expires_at->format('M d, Y') }}</span>
                                @else
                                    <span class="text-green-600 font-semibold">{{ $subscription->expires_at->format('M d, Y') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">₱{{ number_format($subscription->amount_paid, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($subscription->expires_at->isPast())
                                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Expired</span>
                                @else
                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">{{ $subscription->expires_at->diffInDays(now()) }} days</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                No subscriptions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $subscriptions->links() }}
    </div>
</div>
