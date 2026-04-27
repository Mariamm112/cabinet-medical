@extends('layouts.dashboard')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.welcome_back') }}</h1>
    <p class="text-gray-500 mt-1">{{ __('messages.dashboard_subtitle') }}</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Appointments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ __('messages.total_appointments') }}</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAppointments ?? 0 }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-calendar-check text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 flex items-center gap-1">
                <i class="fa-solid fa-arrow-up text-xs"></i>
                <span>{{ __('messages.this_month') }}</span>
            </span>
        </div>
    </div>
    
    <!-- Pending Appointments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ __('messages.pending') }}</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingAppointments ?? 0 }}</p>
            </div>
            <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-clock text-amber-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-gray-500">{{ __('messages.awaiting_confirmation') }}</span>
        </div>
    </div>
    
    <!-- Confirmed Appointments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ __('messages.confirmed') }}</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $confirmedAppointments ?? 0 }}</p>
            </div>
            <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600">{{ __('messages.confirmed_status') }}</span>
        </div>
    </div>
</div>

<!-- Recent Appointments Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ __('messages.recent_appointments') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('messages.recent_appointments_subtitle') }}</p>
        </div>
        <a href="{{ route('appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
            {{ __('messages.view_all') }} <i class="fa-solid fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.patient') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.service') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.date') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.status') }}</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentAppointments ?? [] as $appointment)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">{{ substr($appointment->patient_name ?? 'P', 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $appointment->patient_name ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $appointment->patient_email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-700">{{ $appointment->service->name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date ?? now())->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $appointment->appointment_time ?? '-' }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'confirmed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                'completed' => 'bg-blue-100 text-blue-700',
                            ];
                            $status = $appointment->status ?? 'pending';
                            $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                            {{ __('messages.status_' . $status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="{{ __('messages.view') }}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-calendar-xmark text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">{{ __('messages.no_appointments') }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection