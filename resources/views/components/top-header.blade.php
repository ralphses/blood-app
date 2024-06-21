<!-- Top Header -->
<div class="top-header">
    <div class="header-bar d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <a href="#" class="logo-icon me-3">
                <img src="{{asset('dashboard/assets/images/logo-icon.png')}}" height="30" class="small" alt="">
                <span class="big">
                    <img src="{{asset('dashboard/assets/images/logo-dark.png')}}" height="24" class="logo-light-mode"
                         alt="">
                    <img src="{{asset('dashboard/assets/images/logo-light.png')}}" height="24" class="logo-dark-mode"
                         alt="">
                </span>
            </a>
            <a id="close-sidebar" class="btn btn-icon btn-soft-light" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
            </a>
        </div>

        <ul class="list-unstyled mb-0">



            <li class="list-inline-item mb-0 ms-1">
                <div class="dropdown dropdown-primary">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle p-0"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{auth()->user()->name}}</button>
                    <div class="dropdown-menu dd-menu dropdown-menu-end shadow border-0 mt-3 py-3"
                         style="min-width: 200px;">
                            <div class="flex-1 ms-2">
                                <span class="d-block">{{auth()->user()->name}}</span>
                                <small class="text-muted">{{auth()->user()->role}}</small>
                            </div>
                        <div class="dropdown-divider border-top"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-dark" type="submit"><i class="ti ti-logout"></i>
                                Logout</p></button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Top Header -->
