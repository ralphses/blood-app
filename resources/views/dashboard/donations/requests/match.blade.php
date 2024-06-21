<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Available Donations</h6>
                        </div>
                        <div class="card-body">
                            @if ($availableDonations->isEmpty())
                                <p>No Donations available at the moment. Please check back later.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                            @else
                                <table class="table table-center bg-white mb-0">
                                    <thead>
                                    <tr>
                                        <th class="border-bottom p-3">#</th>
                                        <th class="border-bottom p-3">Donor Name</th>
                                        <th class="border-bottom p-3">Blood Type</th>
                                        <th class="border-bottom p-3">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($availableDonations as $match)
                                        <tr>
                                            <td class="p-3">{{ $loop->index + 1 }}</td>
                                            <td class="p-3">{{ $match->user->name }}</td>
                                            <td class="p-3">{{ $match->blood_type }}</td>
                                            <td class="p-3">
                                                <form action="{{ route('dashboard.appointments.book', ['donation' => $match->id, 'requestId' => $donationRequest->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">Book Appointment</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <!-- Custom Pagination -->
                                <div class="d-flex justify-content-center mt-4 mb-3">
                                    <ul class="pagination mb-0">
                                        @if ($availableDonations->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $availableDonations->previousPageUrl() }}" aria-label="Previous">Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($availableDonations->getUrlRange(1, $availableDonations->lastPage()) as $page => $url)
                                            @if ($page == $availableDonations->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if ($availableDonations->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $availableDonations->nextPageUrl() }}" aria-label="Next">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- End Custom Pagination -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end container -->
</x-app-layout>
