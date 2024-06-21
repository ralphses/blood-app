<header class="main-header clearfix" data-sticky_header="true">

    <div class="top-bar clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <p>Welcome to the blood donation center.</p>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="top-bar-social pull-right">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-google-plus"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="header-wrapper navgiation-wrapper">
        <div class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="logo" href="{{ route('welcome') }}"><img alt="" src="{{ asset('assets/images/logo.png') }}"></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('welcome') }}" title="Home">Home</a></li>
                        <li><a href="#" title="About Us">About Us</a></li>
                        <li class="drop">
                            <a href="#">Donors</a>
                            <ul class="drop-down">
                                <li><a href="{{ route('register') }}" title="Register as Donor">Register as Donor</a></li>
                                <li><a href="#" title="Request Appointment">Request Appointment</a></li>
                            </ul>
                        </li>
                        <li class="drop">
                            <a href="#">Recipients</a>
                            <ul class="drop-down">
                                <li><a href="{{ route('register') }}" title="Register as Recipient">Register as Recipient</a></li>
                            </ul>
                        </li>

                        <li><a href="#" title="Contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</header>
