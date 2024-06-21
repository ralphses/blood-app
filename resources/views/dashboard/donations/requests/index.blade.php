<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Donation Requests</h6>
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('dashboard.donations.requests') }}" class="form-inline" id="searchForm">
                                    <input type="text" class="form-control" id="searchRequest" name="search" placeholder="Search by Recipient Name, Blood Type, Status, or Notes">
                                </form>
                            </div>
                            <div>
                                <a href="{{ route('dashboard.donations.requests.create') }}" class="btn btn-success">Create New Request</a>
                            </div>
                        </div>
                        <div class="table-responsive shadow rounded-bottom" data-simplebar>
                            <table class="table table-center bg-white mb-0">
                                <thead>
                                <tr>
                                    <th class="border-bottom p-3">#</th>
                                    <th class="border-bottom p-3">Code</th>
                                    <th class="border-bottom p-3">Recipient Name</th>
                                    <th class="border-bottom p-3">Blood Type</th>
                                    <th class="border-bottom p-3">Amount</th>
                                    <th class="border-bottom p-3">Urgency Level</th>
                                    <th class="border-bottom p-3">Status</th>
                                    <th class="border-bottom p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($requests as $request)
                                    <tr>
                                        <td class="p-3">{{ $loop->index + 1 }}</td>
                                        <td class="p-3">{{ $request->code }}</td>
                                        <td class="p-3">{{ $request->recipient->name }}</td>
                                        <td class="p-3">{{ $request->blood_type }}</td>
                                        <td class="p-3">{{ $request->amount }}</td>
                                        <td class="p-3">{{ $request->urgency_level }}</td>
                                        <td class="p-3">{{ $request->status }}</td>
                                        <td class="p-3">
                                            <a href="{{ route('dashboard.donations.requests.show', $request->id) }}" class="btn btn-primary btn-sm mb-1">View</a>
                                            <form action="{{ route('dashboard.donations.requests.delete', $request->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Are you sure you want to delete this request?')">Delete</button>
                                            </form>
                                            <a href="{{ route('dashboard.donations.requests.edit', $request->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <ul class="pagination mb-0">
                                <li class="page-item {{ $requests->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $requests->previousPageUrl() }}" aria-label="Previous">Prev</a>
                                </li>

                                @php
                                    $start = max(1, $requests->currentPage() - 3);
                                    $end = min($start + 6, $requests->lastPage());
                                @endphp

                                @if($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $requests->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    <li class="page-item {{ $requests->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $requests->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if($end < $requests->lastPage())
                                    @if($end < $requests->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $requests->url($requests->lastPage()) }}">{{ $requests->lastPage() }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $requests->currentPage() == $requests->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $requests->nextPageUrl() }}" aria-label="Next">Next</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div><!-- end container -->

</x-app-layout>

<script>
    document.getElementById("searchRequest").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default form submission
            const searchValue = document.getElementById("searchRequest").value;
            window.location.href = "{{ route('dashboard.donations.requests') }}" + "?search=" + searchValue;
        }
    });
</script>
