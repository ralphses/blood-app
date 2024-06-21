<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">User Details</h6>
                        </div>
                        <div class="card-body">
                            <!-- User Information -->
                            <div class="user-info">
                                <h3>{{ $user->name }}</h3>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Phone Number:</strong> {{ $user->phone }}</p>
                                <p><strong>Blood Type:</strong> {{ $user->blood_type }}</p>
                                <p><strong>Address:</strong> {{ $user->address }}</p>
                            </div>

                            <!-- User Donations Table -->
                            <div class="table-responsive mt-4">
                                <h5>User Donations</h5>
                                <table class="table table-center bg-white mb-0">
                                    <thead>
                                    <tr>
                                        <th class="border-bottom p-3">#</th>
                                        <th class="border-bottom p-3">Donation Date</th>
                                        <th class="border-bottom p-3">Donation Amount</th>
                                        <th class="border-bottom p-3">Donation Center</th>
                                        <!-- Add more headers if needed -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($donations as $donation)
                                        <tr>
                                            <td class="p-3">{{ $loop->iteration }}</td>
                                            <td class="p-3">{{ $donation->date }}</td>
                                            <td class="p-3">{{ $donation->amount }}</td>
                                            <td class="p-3">{{ $donation->center }}</td>
                                            <!-- Add more columns if needed -->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center p-3">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <!-- Custom Pagination Links -->
                                <div class="d-flex justify-content-center mt-4 mb-3">
                                    <ul class="pagination mb-0">
                                        <li class="page-item {{ $donations->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $donations->previousPageUrl() }}" aria-label="Previous">Prev</a>
                                        </li>

                                        @php
                                            $start = max(1, $donations->currentPage() - 3);
                                            $end = min($start + 6, $donations->lastPage());
                                        @endphp

                                        @if($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $donations->url(1) }}">1</a>
                                            </li>
                                            @if($start > 2)
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                            @endif
                                        @endif

                                        @for ($page = $start; $page <= $end; $page++)
                                            <li class="page-item {{ $donations->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $donations->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endfor

                                        @if($end < $donations->lastPage())
                                            @if($end < $donations->lastPage() - 1)
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $donations->url($donations->lastPage()) }}">{{ $donations->lastPage() }}</a>
                                            </li>
                                        @endif

                                        <li class="page-item {{ $donations->currentPage() == $donations->lastPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $donations->nextPageUrl() }}" aria-label="Next">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- User Donation Requests Table -->
                            <div class="table-responsive mt-4">
                                <h5>User Donation Requests</h5>
                                <table class="table table-center bg-white mb-0">
                                    <thead>
                                    <tr>
                                        <th class="border-bottom p-3">#</th>
                                        <th class="border-bottom p-3">Request Date</th>
                                        <th class="border-bottom p-3">Requested Amount</th>
                                        <th class="border-bottom p-3">Request Status</th>
                                        <!-- Add more headers if needed -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($donationRequests as $request)
                                        <tr>
                                            <td class="p-3">{{ $loop->iteration }}</td>
                                            <td class="p-3">{{ $request->date }}</td>
                                            <td class="p-3">{{ $request->amount }}</td>
                                            <td class="p-3">{{ $request->status }}</td>
                                            <!-- Add more columns if needed -->
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center p-3">No data to display</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <!-- Custom Pagination Links -->
                                <div class="d-flex justify-content-center mt-4 mb-3">
                                    <ul class="pagination mb-0">
                                        <li class="page-item {{ $donationRequests->currentPage() == 1 ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $donationRequests->previousPageUrl() }}" aria-label="Previous">Prev</a>
                                        </li>

                                        @php
                                            $start = max(1, $donationRequests->currentPage() - 3);
                                            $end = min($start + 6, $donationRequests->lastPage());
                                        @endphp

                                        @if($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $donationRequests->url(1) }}">1</a>
                                            </li>
                                            @if($start > 2)
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                            @endif
                                        @endif

                                        @for ($page = $start; $page <= $end; $page++)
                                            <li class="page-item {{ $donationRequests->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $donationRequests->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endfor

                                        @if($end < $donationRequests->lastPage())
                                            @if($end < $donationRequests->lastPage() - 1)
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $donationRequests->url($donationRequests->lastPage()) }}">{{ $donationRequests->lastPage() }}</a>
                                            </li>
                                        @endif

                                        <li class="page-item {{ $donationRequests->currentPage() == $donationRequests->lastPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $donationRequests->nextPageUrl() }}" aria-label="Next">Next</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
