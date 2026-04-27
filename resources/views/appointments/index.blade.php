@extends('layouts.app')

@section('content')

<!-- Button -->
<button data-modal-target="createModal" data-modal-toggle="createModal"
    class="bg-blue-600 text-white px-4 py-2 rounded">
    New Appointment
</button>

<!-- Modal -->
<div id="createModal" class="hidden fixed top-0 left-0 right-0 z-50">
    <!-- modal content here -->
</div>

@endsection