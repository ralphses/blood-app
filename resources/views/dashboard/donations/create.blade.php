@php use App\Models\User; @endphp
<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">New Donation</h6>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('dashboard.donations.create') }}" method="POST">
                                @csrf

                                @can('isAdmin', User::class)

                                    <div class="mb-3">
                                        <label for="blood_type" class="form-label">Blood Type</label>
                                        <select class="form-select" id="blood_type" name="blood_type" required>
                                            <option
                                                value="{{auth()->user()->blood_type}}">{{auth()->user()->blood_type}}</option>

                                            @foreach($bloodTypes as $key => $bloodType)
                                                <option value="{{$key}}">{{$key}} ({{$bloodType}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endcan

                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount (Pint)</label>
                                    <input type="number" step="0.01" class="form-control" id="amount" name="amount"
                                           value="{{ old('amount') }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Create Donation</button>
                                <a href="{{ route('dashboard.donations') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end container-->

</x-app-layout>
