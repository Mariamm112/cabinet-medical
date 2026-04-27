@extends('layouts.dashboard')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.appointments') }}</h1>
        <p class="text-gray-500 mt-1">{{ __('messages.appointments_subtitle') }}</p>
    </div>
    <button onclick="openModal('createModal')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
        <i class="fa-solid fa-plus"></i>
        {{ __('messages.new_appointment') }}
    </button>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="{{ __('messages.search_appointments') }}" 
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ request('q') }}">
            </div>
        </div>
        
        <!-- Status Filter -->
        <div class="w-full md:w-48">
            <select id="statusFilter" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">{{ __('messages.all_statuses') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>{{ __('messages.confirmed') }}</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('messages.cancelled') }}</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
            </select>
        </div>
        
        <!-- Date Filter -->
        <div class="w-full md:w-48">
            <input type="date" id="dateFilter" 
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                value="{{ request('date') }}">
        </div>
    </div>
</div>

<!-- Appointments Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full" id="appointmentsTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.patient') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.service') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.date_time') }}</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.status') }}</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="appointmentsBody">
                @include('appointments.partials.results')
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('createModal')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.create_appointment') }}</h3>
                <button onclick="closeModal('createModal')" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('appointments.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.patient_name') }}</label>
                        <input type="text" name="patient_name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.patient_email') }}</label>
                        <input type="email" name="patient_email" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.patient_phone') }}</label>
                        <input type="tel" name="patient_phone" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.service') }}</label>
                        <select name="service_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">{{ __('messages.select_service') }}</option>
                            @foreach($services ?? [] as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.date') }}</label>
                            <input type="date" name="appointment_date" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.time') }}</label>
                            <input type="time" name="appointment_time" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.notes') }}</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('createModal')" class="px-4 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">{{ __('messages.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('deleteModal')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md transform transition-all">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.confirm_delete') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('messages.delete_warning') }}</p>
                <div class="flex items-center justify-center gap-3">
                    <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium">{{ __('messages.cancel') }}</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">{{ __('messages.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    openModal('deleteModal');
}

let searchTimeout;
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');
const dateFilter = document.getElementById('dateFilter');

function fetchAppointments() {
    const query = searchInput.value;
    const status = statusFilter.value;
    const date = dateFilter.value;
    
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const params = new URLSearchParams();
        if (query) params.append('q', query);
        if (status) params.append('status', status);
        if (date) params.append('date', date);
        
        fetch(`{{ route('appointments.search') }}?${params.toString()}`, {
            headers: { 'Accept': 'text/html' }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('appointmentsBody').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
    }, 300);
}

searchInput.addEventListener('input', fetchAppointments);
statusFilter.addEventListener('change', fetchAppointments);
dateFilter.addEventListener('change', fetchAppointments);
</script>
@endsection