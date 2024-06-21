<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">

            <!-- Customer Table Section -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Users Management</h6>
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('dashboard.users') }}" class="form-inline" id="searchForm">
                                    <input type="text" class="form-control" id="searchCustomer" name="search" placeholder="Search by Name, Email, Phone, or Order Number">
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive shadow rounded-bottom" data-simplebar>
                            <table class="table table-center bg-white mb-0">
                                <thead>
                                <tr>
                                    <th class="border-bottom p-3">#</th>
                                    <th class="border-bottom p-3">Name</th>
                                    <th class="border-bottom p-3">Email</th>
                                    <th class="border-bottom p-3">Phone Number</th>
                                    <th class="border-bottom p-3">Blood Type</th>
                                    <th class="border-bottom p-3">Donations</th>
                                    <th class="border-bottom p-3">Donation Requests</th>
                                    <th class="border-bottom p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Start -->
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="p-3">{{ $loop->index + 1 }}</td>
                                        <td class="p-3">{{ $user->name }}</td>
                                        <td class="p-3">{{ $user->email }}</td>
                                        <td class="p-3">{{ $user->phone }}</td>
                                        <td class="p-3">{{ $user->blood_type }}</td>
                                        <td class="p-3">{{ $user->donations->count() }}</td>
                                        <td class="p-3">{{ $user->donationRequests->count() }}</td>
                                        <td class="p-3">
                                            <a href="{{ route('dashboard.users.show', $user->id) }}" class="btn btn-primary btn-sm">View</a>
                                            <form action="{{ route('dashboard.users.delete', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                            <a href="{{ route('dashboard.users.role', $user->id) }}" class="btn btn-warning btn-sm">Manage Role</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- End -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <ul class="pagination mb-0">
                                <li class="page-item {{ $users->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">Prev</a>
                                </li>

                                @php
                                    $start = max(1, $users->currentPage() - 3);
                                    $end = min($start + 6, $users->lastPage());
                                @endphp

                                @if($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if($end < $users->lastPage())
                                    @if($end < $users->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $users->currentPage() == $users->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">Next</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div><!--end container-->

</x-app-layout>

<script>
    document.getElementById("searchCustomer").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default form submission
            const searchValue = document.getElementById("searchCustomer").value;
            window.location.href = "{{ route('dashboard.users') }}" + "?search=" + searchValue;
        }
    });
</script>
