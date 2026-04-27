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
<input type="text" id="search" placeholder="Search by status..."
    class="border p-2 w-full mb-4">

<div id="results">
    {{-- Initial data (optional) --}}
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.querySelector("#search").addEventListener("input", function () {
    axios.get('/appointments/search?q=' + this.value)
        .then(res => {
            document.querySelector("#results").innerHTML = res.data;
        });
});
</script>
@endsection