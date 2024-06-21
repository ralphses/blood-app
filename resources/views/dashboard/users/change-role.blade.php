<x-app-layout>

    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Change User Role</h6>
                        </div>
                        <div class="card-body">
                            <!-- User Role Change Form -->
                            <form action="{{ route('dashboard.users.role', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="userName" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="userName" value="{{ $user->name }}"
                                           readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="userRole" class="form-label">Select New Role</label>
                                    <select class="form-control" id="userRole" name="role">
                                        <option selected>
                                            Select New Role
                                        </option>
                                        @foreach($roles as $role)
                                            <option
                                                value="{{ $role }}" {{$role == $user->role ? "selected" : ""}}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Change Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
