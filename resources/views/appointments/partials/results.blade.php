@forelse($appointments ?? [] as $appointment)
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
            <button onclick="confirmDelete('{{ route('appointments.destroy', $appointment->id) }}')" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="{{ __('messages.delete') }}">
                <i class="fa-solid fa-trash"></i>
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