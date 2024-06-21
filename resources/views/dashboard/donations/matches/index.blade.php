<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">

            <!-- Donation Matches Table Section -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Donation Matches</h6>
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('dashboard.donation.matches') }}" class="form-inline" id="searchForm">
                                    <input type="text" class="form-control" id="searchMatch" name="search" placeholder="Search by Donor Name, Recipient Name, Blood Type, or Status">
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive shadow rounded-bottom" data-simplebar>
                            <table class="table table-center bg-white mb-0">
                                <thead>
                                <tr>
                                    <th class="border-bottom p-3">#</th>
                                    <th class="border-bottom p-3">Donor Name</th>
                                    <th class="border-bottom p-3">Recipient Name</th>
                                    <th class="border-bottom p-3">Blood Type</th>
                                    <th class="border-bottom p-3">Status</th>
                                    <th class="border-bottom p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($matches as $match)
                                    <tr>
                                        <td class="p-3">{{ $loop->index + 1 }}</td>
                                        <td class="p-3">{{ $match->donor->name }}</td>
                                        <td class="p-3">{{ $match->recipient->name }}</td>
                                        <td class="p-3">{{ $match->blood_type }}</td>
                                        <td class="p-3">{{ $match->status }}</td>
                                        <td class="p-3">
                                            <a href="{{ route('dashboard.donation.matches.show', $match->id) }}" class="btn btn-primary btn-sm">View</a>
                                            <form action="{{ route('dashboard.donation.matches.cancel', $match->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this matches?')">Cancel</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <ul class="pagination mb-0">
                                <li class="page-item {{ $matches->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $matches->previousPageUrl() }}" aria-label="Previous">Prev</a>
                                </li>

                                @php
                                    $start = max(1, $matches->currentPage() - 3);
                                    $end = min($start + 6, $matches->lastPage());
                                @endphp

                                @if($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $matches->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    <li class="page-item {{ $matches->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $matches->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if($end < $matches->lastPage())
                                    @if($end < $matches->lastPage() - 1)
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $matches->url($matches->lastPage()) }}">{{ $matches->lastPage() }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $matches->currentPage() == $matches->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $matches->nextPageUrl() }}" aria-label="Next">Next</a>
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
    document.getElementById("searchMatch").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default form submission
            const searchValue = document.getElementById("searchMatch").value;
            window.location.href = "{{ route('dashboard.donation.matches') }}" + "?search=" + searchValue;
        }
    });
</script>
