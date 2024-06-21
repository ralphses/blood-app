@php use App\Models\User; @endphp
<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">

            <!-- Appointments Table Section -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">All Donation Appointments</h6>
                        </div>
                        <div class="table-responsive shadow rounded-bottom" data-simplebar>
                            <table class="table table-center bg-white mb-0">
                                <thead>
                                <tr>
                                    <th class="border-bottom p-3">#</th>
                                    @can('isRecipient', User::class)
                                        <th class="border-bottom p-3">Donor</th>
                                    @endcan
                                    @can('isDonor', User::class)
                                        <th class="border-bottom p-3">Recipient</th>
                                    @endcan
                                    <th class="border-bottom p-3">Donation Code</th>
                                    <th class="border-bottom p-3">Appointment Date</th>
                                    <th class="border-bottom p-3">Appointment Time</th>
                                    <th class="border-bottom p-3">Location</th>
                                    <th class="border-bottom p-3">Status</th>
                                    @cannot('isAdmin', User::class)
                                        <th class="border-bottom p-3">Action</th>
                                    @endcannot

                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td class="p-3">{{ $loop->index + 1 }}</td>
                                        @can('isRecipient', User::class)
                                            <td class="p-3">{{ $appointment->donationMatch->donor->name }}</td>
                                        @endcan
                                        @can('isDonor', User::class)
                                            <td class="p-3">{{ $appointment->donationMatch->recipient->name }}</td>
                                        @endcan
                                        <td class="p-3">{{ $appointment->donation->code }}</td>
                                        <td class="p-3">{{ $appointment->appointment_date }}</td>
                                        <td class="p-3">{{ $appointment->appointment_time }}</td>
                                        <td class="p-3">{{ $appointment->location->address }}</td>
                                        <td class="p-3">{{ $appointment->status }}</td>
                                        @cannot('isAdmin', User::class)
                                            <td class="p-3">
                                                @if($appointment->status == 'SCHEDULED'))
                                                    <a href="{{ route('dashboard.appointments.track', $appointment->id) }}"
                                                       class="btn btn-warning btn-sm">Track</a>
                                                @elseif(in_array($appointment->status, ['REQUESTED', 'CREATED']))
                                                    <a href="{{ route('dashboard.appointments.modify', $appointment->id) }}"
                                                       class="btn btn-primary btn-sm">Modify</a>
                                                @else
                                                    <a href="#" class="btn btn-primary btn-sm disabled">Modify</a>
                                                @endif

                                            </td>
                                        @endcannot
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center p-3">No data to display</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Custom Pagination -->
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <ul class="pagination mb-0">
                                <li class="page-item {{ $appointments->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $appointments->previousPageUrl() }}"
                                       aria-label="Previous">Prev</a>
                                </li>

                                @php
                                    $start = max(1, $appointments->currentPage() - 3);
                                    $end = min($start + 6, $appointments->lastPage());
                                @endphp

                                @if($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $appointments->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    <li class="page-item {{ $appointments->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $appointments->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if($end < $appointments->lastPage())
                                    @if($end < $appointments->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $appointments->url($appointments->lastPage()) }}">{{ $appointments->lastPage() }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $appointments->currentPage() == $appointments->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $appointments->nextPageUrl() }}" aria-label="Next">Next</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div><!--end container-->

</x-app-layout>
