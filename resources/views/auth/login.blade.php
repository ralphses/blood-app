<x-guest-layout>

    <section class="section-content-block section-contact-block">

        <div class="container">

            <div class="justify-content-center"> <!-- Center the form container -->

                <div class="col-sm-6 wow">

                    <div class="contact-form-block">

                        <h2 class="contact-title text-black">Login</h2>

                        <form role="form" action="{{ route('login') }}" method="post" id="contact-forms">
                            @csrf

                            <div class="form-group">
                                <input type="email" class="form-control" id="user_email" name="email" placeholder="Email"
                                       data-msg="Please enter your email address"/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" id="user_password" name="password"
                                       placeholder="Password" data-msg="Please enter your password"/>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-custom">Login</button>
                                <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>

                            </div>

                        </form>

                        <div class="text-center">

                        </div>

                    </div> <!-- end .contact-form-block  -->

                </div> <!--  end col-sm-6  -->

            </div> <!-- end row justify-content-center -->

        </div> <!--  end .container -->

    </section> <!-- end .section-content-block  -->

    <!-- START FOOTER  -->


    <!-- END FOOTER  -->

    <!-- Back To Top Button  -->
</x-guest-layout>
