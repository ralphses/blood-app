<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Track Appointment</h6>
                        </div>
                        <div class="card-body">
                            <h5>Appointment Details</h5>
                            <p><strong>Donor:</strong> {{ $appointment->donationMatch->donor->name }}</p>
                            <p><strong>Recipient:</strong> {{ $appointment->donationMatch->recipient->name }}</p>
                            <p><strong>Appointment Date:</strong> {{ $appointment->appointment_date }}</p>
                            <p><strong>Appointment Time:</strong> {{ $appointment->appointment_time }}</p>
                            <p><strong>Location:</strong> {{ $location->address }}</p>
                            <div id="map" style="height: 600px;"></div>

                            @if(auth()->user()->canany(['isRecipient', 'isAdmin'], App\Models\User::class) && $appointment->status !== 'completed')
                                <form action="{{ route('dashboard.appointments.mark-complete', $appointment->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Mark as Completed</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <!-- Leaflet Geocoding Service (Nominatim) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.min.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.min.js"></script>

    <!-- Leaflet Realtime Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-realtime/2.2.0/leaflet-realtime.min.js" integrity="sha512-lLUl/IVVjrkzQWAtFwvpmy5OJcWxwX9PyDslgi7RO6Uz6a/nrz+C6bxKkR34DT/7yeUr0JC8JyrFEjBGAgo+bA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 17); // Zoom level adjusted to 17 for closer view

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Custom vehicle icon for appointment location
            const vehicleIcon = L.icon({
                iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png', // Adjust the URL to your vehicle icon
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
            });

            // Realtime tracking setup for donor or recipient
            @if(Auth::user()->can('isDonor', App\Models\User::class))
            const marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], { icon: vehicleIcon }).addTo(map)
                .bindPopup(`<strong>Appointment Location</strong><br>{{ $location->address }}`);

            // Function to update donor's current location and send to the server
            function updateDonorLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        marker.setLatLng([latitude, longitude]).update(); // Update marker position
                        map.setView([latitude, longitude], 17); // Adjust map view to new location
                        sendLocationToApi(latitude, longitude); // Send updated location to the API
                    }, function(error) {
                        console.error('Error getting donor location:', error);
                    });
                } else {
                    console.error('Geolocation is not supported by this browser.');
                }
            }

            // Call function to update donor's location every 5 seconds
            setInterval(updateDonorLocation, 5000); // Adjust interval as needed

            // Function to send location data to API (mock example)
            function sendLocationToApi(latitude, longitude) {
                // Replace with your actual API endpoint and data sending logic
                fetch('{{ route("dashboard.appointments.update-location", $appointment->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        latitude: latitude,
                        longitude: longitude,
                        appointment: {{$appointment->id}}
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Location sent to API:', data);
                        // Handle API response if needed
                    })
                    .catch(error => {
                        console.error('Error sending location to API:', error);
                        // Handle error if needed
                    });
            }
            @else
            const realtime = L.realtime({
                url: '{{ route("api.appointments.location", $appointment->id) }}',
                crossOrigin: true,
                type: 'json',
                getFeatureId: function (feature) {
                    return feature.properties.id;
                },
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, { icon: vehicleIcon }).bindPopup(`<strong>${feature.properties.title}</strong><br>${feature.properties.description}`);
                }
            }, {
                interval: 2000, // Update interval in milliseconds
                cache: false // Disable caching for real-time updates
            }).addTo(map);

            realtime.on('update', function() {
                // Handle updates if needed
            });
            @endif
        });
    </script>
</x-app-layout>
