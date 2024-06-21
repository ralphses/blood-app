<!-- resources/views/appointments/edit.blade.php -->
<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">

            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Edit Appointment</h6>
                        </div>
                        <div class="p-4">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('dashboard.appointments.modify', ['appointment' => $appointment->id]) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Appointment Date</label>
                                    <input type="date" id="appointment_date" name="appointment_date" class="form-control" value="{{ $appointment->appointment_date }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="appointment_time" class="form-label">Appointment Time</label>
                                    <input type="time" id="appointment_time" name="appointment_time" class="form-control" value="{{ $appointment->appointment_time }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ $appointment->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div><!--end container-->

</x-app-layout>
