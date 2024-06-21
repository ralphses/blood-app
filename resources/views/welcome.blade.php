<x-guest-layout>
    <div class="slider-wrap">
        <div id="slider_1" class="owl-carousel owl-theme">
            <div class="item">
                <img src="{{ asset('assets/images/home_1_slider_1.jpg') }}" alt="img">
                <div class="slider-content text-center">
                    <div class="container">
                        <div class="slider-contents-info">
                            <h3>Donate Blood, Save Lives!</h3>
                            <h2>
                                Your Donation Can Bring
                                <br>
                                A Smile to Someone's Face
                            </h2>
                            <a href="{{ route('register') }}" class="btn btn-slider">Register Now <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="{{ asset('assets/images/home_1_slider_1.jpg') }}" alt="img">
                <div class="slider-content text-center">
                    <div class="container">
                        <div class="slider-contents-info">
                            <h3>Join Our Blood Donation Community</h3>
                            <h2>
                                Donate Blood and
                                <br>
                                Inspire Others
                            </h2>
                            <a href="{{ route('register') }}" class="btn btn-slider">Join Us <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="cta-section-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h2>We Are Optimizing Blood Bank Operations</h2>
                    <p>
                        Our system ensures efficient donor-recipient matching and tracks donations from collection to transfusion.
                        Join us in making a difference by donating blood or requesting a donation today.
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <a class="btn btn-cta-1" href="#">Request Appointment</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-content-block section-process">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <h2 class="section-heading"><span>Donation</span> Process</h2>
                    <p class="section-subheading">The donation process from the time you arrive at the center until the time you leave</p>
                </div>
            </div>
            <div class="row wow fadeInUp">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="process-layout">
                        <figure class="process-img">
                            <img src="{{ asset('assets/images/process_1.jpg') }}" alt="process"/>
                            <div class="step">
                                <h3>1</h3>
                            </div>
                        </figure>
                        <article class="process-info">
                            <h2>Registration</h2>
                            <p>Complete a simple registration form with all required contact information to start the donation process.</p>
                        </article>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="process-layout">
                        <figure class="process-img">
                            <img src="{{ asset('assets/images/process_2.jpg') }}" alt="process"/>
                            <div class="step">
                                <h3>2</h3>
                            </div>
                        </figure>
                        <article class="process-info">
                            <h2>Screening</h2>
                            <p>A drop of blood from your finger will be taken for a simple test to ensure that your blood iron levels are proper enough for donation.</p>
                        </article>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="process-layout">
                        <figure class="process-img">
                            <img src="{{ asset('assets/images/process_3.jpg') }}" alt="process"/>
                            <div class="step">
                                <h3>3</h3>
                            </div>
                        </figure>
                        <article class="process-info">
                            <h2>Donation</h2>
                            <p>After successfully passing the screening test, you will be directed to a donor bed for donation. It takes only 6-10 minutes.</p>
                        </article>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="process-layout">
                        <figure class="process-img">
                            <img src="{{ asset('assets/images/process_4.jpg') }}" alt="process"/>
                            <div class="step">
                                <h3>4</h3>
                            </div>
                        </figure>
                        <article class="process-info">
                            <h2>Refreshment</h2>
                            <p>You can stay in the sitting room until you feel strong enough to leave. You will receive a refreshment from us in the donation zone.</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-counter" data-stellar-background-ratio="0.3">
        <div class="container wow fadeInUp">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="counter-block-1 text-center">
                        <i class="fa fa-heartbeat icon"></i>
                        <span class="counter">2578</span>
                        <h4>Success Smile</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="counter-block-1 text-center">
                        <i class="fa fa-stethoscope icon"></i>
                        <span class="counter">3235</span>
                        <h4>Happy Donors</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="counter-block-1 text-center">
                        <i class="fa fa-users icon"></i>
                        <span class="counter">3568</span>
                        <h4>Happy Recipients</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="counter-block-1 text-center">
                        <i class="fa fa-building icon"></i>
                        <span class="counter">1364</span>
                        <h4>Total Awards</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-content-block cta-section-3">
        <div class="container wow fadeIn animated">
            <div class="row">
                <div class="col-md-12">
                    <div class="cta-content text-center">
                        <h2>Join Us and Save Lives</h2>
                        <a class="btn-cta-3" href="#">Become a Donor</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
