@forelse($appointments as $appointment)
    <div class="p-2 border-b">
        <strong>{{ $appointment->name }}</strong> - {{ $appointment->status }}
    </div>
@empty
    <div class="p-2 text-gray-500">No results</div>
@endforelse