@extends('layouts.dashboard')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.services') }}</h1>
        <p class="text-gray-500 mt-1">{{ __('messages.services_subtitle') }}</p>
    </div>
    <button onclick="openModal('createModal')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
        <i class="fa-solid fa-plus"></i>
        {{ __('messages.new_service') }}
    </button>
</div>

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($services ?? [] as $service)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                <i class="fa-solid fa-stethoscope text-blue-600 text-xl"></i>
            </div>
            <div class="flex items-center gap-1">
                <button onclick="openEditModal('{{ $service->id }}', '{{ $service->name }}', '{{ $service->description }}', '{{ $service->duration }}', '{{ $service->price }}')" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="{{ __('messages.edit') }}">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button onclick="confirmDelete('{{ route('services.destroy', $service->id) }}')" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="{{ __('messages.delete') }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $service->description ?? __('messages.no_description') }}</p>
        
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fa-solid fa-clock"></i>
                <span>{{ $service->duration }} {{ __('messages.minutes') }}</span>
            </div>
            <div class="text-lg font-bold text-blue-600">
                {{ number_format($service->price, 2) }} €
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <i class="fa-solid fa-hand-holding-medical text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-500 text-lg">{{ __('messages.no_services') }}</p>
            <button onclick="openModal('createModal')" class="mt-4 text-blue-600 hover:text-blue-700 font-medium">
                {{ __('messages.add_first_service') }}
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('createModal')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.create_service') }}</h3>
                <button onclick="closeModal('createModal')" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ route('services.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.service_name') }}</label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.description') }}</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.duration') }}</label>
                            <div class="relative">
                                <input type="number" name="duration" required min="15" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">{{ __('messages.min') }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.price') }}</label>
                            <div class="relative">
                                <input type="number" name="price" required min="0" step="0.01" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">€</span>
                            </div>
                        </div>
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

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('editModal')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg transform transition-all">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.edit_service') }}</h3>
                <button onclick="closeModal('editModal')" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="editForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.service_name') }}</label>
                        <input type="text" name="name" id="editName" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.description') }}</label>
                        <textarea name="description" id="editDescription" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.duration') }}</label>
                            <div class="relative">
                                <input type="number" name="duration" id="editDuration" required min="15" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">{{ __('messages.min') }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.price') }}</label>
                            <div class="relative">
                                <input type="number" name="price" id="editPrice" required min="0" step="0.01" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">€</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('editModal')" class="px-4 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">{{ __('messages.update') }}</button>
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

function openEditModal(id, name, description, duration, price) {
    document.getElementById('editForm').action = '/services/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editDescription').value = description || '';
    document.getElementById('editDuration').value = duration;
    document.getElementById('editPrice').value = price;
    openModal('editModal');
}
</script>
@endsection