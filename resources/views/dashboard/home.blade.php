@php use App\Models\User; @endphp
<x-app-layout>

    <x-top-header/>
    <div class="container-fluid">
        <div class="layout-specing">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted mb-1">Welcome back, {{auth()->user()->name}}!</h6>
                    <h5 class="mb-0">Today looks good huh!</h5>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        @canany(['isRecipient', 'isAdmin'], User::class)
                            <form action="{{ route('dashboard.donations.requests.donations') }}" method="GET"
                                  class="d-flex me-3">
                                <input type="text" name="request_code" class="form-control form-control-sm"
                                       placeholder="Enter request code..." aria-label="Search" style="width: 300px;">
                                <button type="submit" class="btn btn-primary btn-sm ms-2">Get Donations</button>
                            </form>
                        @endcanany

                        @canany(['isDonor', 'isAdmin'], User::class)
                            <a href="{{ route('dashboard.donations.create') }}" class="btn btn-danger btn-sm me-2">Create
                                New Donation</a>
                        @endcanany

                        @canany(['isRecipient', 'isAdmin'], User::class)
                            <a href="{{ route('dashboard.donations.requests.create') }}" class="btn btn-warning btn-sm">Make
                                New Request</a>
                        @endcanany
                    </div>

                    <div class="row">
                        <h4>Appointments ({{ $data['appointments']['count'] }})</h4>
                        <div class="col-md-4 mb-2">
                            <div
                                class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-1 ms-3">
                                        <h6 class="mb-0 text-muted">Scheduled</h6>
                                        <p class="fs-5 text-dark fw-bold mb-0">{{ $data['appointments']['stats']['SCHEDULED'] ?? 0 }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-4 mb-2">
                            <div
                                class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-1 ms-3">
                                        <h6 class="mb-0 text-muted">Created</h6>
                                        <p class="fs-5 text-dark fw-bold mb-0">{{ $data['appointments']['stats']['REQUESTED'] ?? 0 }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->

                        <div class="col-md-4 mb-2">
                            <div
                                class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-1 ms-3">
                                        <h6 class="mb-0 text-muted">Declined</h6>
                                        <p class="fs-5 text-dark fw-bold mb-0">{{ $data['appointments']['stats']['CANCELED'] ?? 0 }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
            </div>

            @canany(['isRecipient', 'isAdmin'], User::class)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <h4>Donation Requests ({{ $data['donation-requests']['count'] }})</h4>
                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Canceled</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donation-requests']['stats']['CANCELED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Pending</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donation-requests']['stats']['PENDING'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Completed</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donation-requests']['stats']['COMPLETED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>
            @endcanany

            @can('isDonor', User::class)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <h4>Donations ({{ $data['donations']['count'] }})</h4>
                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Pending</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donations']['stats']['PENDING'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Completed</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donations']['stats']['COMPLETED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Canceled</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donations']['stats']['CANCELED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>
            @endcan

            @can('isAdmin', User::class)
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <h4>Donations ({{ $data['donations']['count'] }})</h4>
                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Pending</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donations']['stats']['PENDING'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Completed</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donations']['stats']['COMPLETED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-md-4 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Canceled</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donations']['stats']['CANCELED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <h4>Users ({{ $data['users']['count'] }})</h4>
                            <div class="col-md-6 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Recipients</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['users']['stats']['RECIPIENT'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-6 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Donors</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['users']['stats']['DONOR'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <h4>Donation Matches ({{ $data['donation-match']['count'] }})</h4>
                            <div class="col-md-6 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Confirmed</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donation-match']['stats']['CONFIRMED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-6 mb-2">
                                <div
                                    class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-1 ms-3">
                                            <h6 class="mb-0 text-muted">Declined</h6>
                                            <p class="fs-5 text-dark fw-bold mb-0">{{ $data['donation-match']['stats']['DECLINED'] ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>
            @endcan


        </div>
    </div><!--end container-->

</x-app-layout>
