<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">

            <!-- Donations Table Section -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">All Donations</h6>
                            <div>
                                <form action="{{ route('dashboard.donations') }}" method="GET" class="form-inline"
                                      id="searchForm">
                                    <input type="text" class="form-control" id="searchDonation" name="search"
                                           placeholder="Search by Donor Name or Status">
                                    <button type="submit" class="btn btn-primary btn-sm ml-2 mt-2">Search</button>
                                </form>
                                <a href="{{ route('dashboard.donations.create') }}"
                                   class="btn btn-success btn-sm ml-2 mt-2">New Donation</a>
                            </div>
                        </div>
                        <div class="table-responsive shadow rounded-bottom" data-simplebar>
                            <table class="table table-center bg-white mb-0">
                                <thead>
                                <tr>
                                    <th class="border-bottom p-3">#</th>
                                    <th class="border-bottom p-3">Code</th>
                                    <th class="border-bottom p-3">Blood Type</th>
                                    <th class="border-bottom p-3">Amount (Pint)</th>
                                    <th class="border-bottom p-3">Status</th>
                                    <th class="border-bottom p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($donations as $donation)
                                    <tr>
                                        <td class="p-3">{{ $loop->index + 1 }}</td>
                                        <td class="p-3">{{ $donation->code }}</td>
                                        <td class="p-3">{{ $donation->blood_type }}</td>
                                        <td class="p-3">{{ $donation->amount }}</td>
                                        <td class="p-3">{{ $donation->status }}</td>
                                        <td class="p-3">
                                            <form action="{{ route('dashboard.donations.cancel', $donation->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm
                                                {{in_array($donation->status, ["CANCELED", "COMPLETED"]) ? 'disabled' : ''}}
                                                ">Cancel
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center p-3">No data to display</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Custom Pagination -->
                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <ul class="pagination mb-0">
                                <li class="page-item {{ $donations->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $donations->previousPageUrl() }}"
                                       aria-label="Previous">Prev</a>
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
                                        <a class="page-link"
                                           href="{{ $donations->url($donations->lastPage()) }}">{{ $donations->lastPage() }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $donations->currentPage() == $donations->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $donations->nextPageUrl() }}" aria-label="Next">Next</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div><!--end container-->

</x-app-layout>
