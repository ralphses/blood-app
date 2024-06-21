<!-- resources/views/dashboard/appointments/request.blade.php -->

<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Request Appointment</h6>
                        </div>
                        <div class="card-body">
                            <!-- Display Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('dashboard.appointments.request') }}" method="POST">
                                @csrf

                                <input type="hidden" name="donation" value="{{ $donation->id }}">
                                <input type="hidden" name="donationRequest" value="{{ $donationRequest->id }}">

                                <div class="mb-3">
                                    <label for="donor_name" class="form-label">Donor Name</label>
                                    <input type="text" class="form-control" id="donor_name" value="{{ $donation->user->name }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="blood_type" class="form-label">Blood Type</label>
                                    <input type="text" class="form-control" id="blood_type" value="{{ $donation->blood_type }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Appointment Date</label>
                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                    @if ($errors->has('appointment_date'))
                                        <div class="text-danger">{{ $errors->first('appointment_date') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="appointment_time" class="form-label">Appointment Time</label>
                                    <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::now()->format('H:i')) }}" required>
                                    @if ($errors->has('appointment_time'))
                                        <div class="text-danger">{{ $errors->first('appointment_time') }}</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required placeholder="Address for actual donation">
                                    @if ($errors->has('location'))
                                        <div class="text-danger">{{ $errors->first('location') }}</div>
                                    @endif
                                </div>

                                <div id="map" style="height: 400px;"></div>

                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                                    @if ($errors->has('notes'))
                                        <div class="text-danger">{{ $errors->first('notes') }}</div>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Submit Request</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Leaflet Geocoding Service (Nominatim) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([51.505, -0.09], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            let marker;

            function onMapClick(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const address = data.display_name;
                        document.getElementById('location').value = address;
                    });
            }

            map.on('click', onMapClick);
        });
    </script>
</x-app-layout>
