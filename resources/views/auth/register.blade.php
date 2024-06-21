<x-guest-layout>

    <section class="section-content-block section-contact-block">

        <div class="container">

            <div class="justify-content-center"> <!-- Center the form container -->

                <div class="col-sm-6 wow">

                    <div class="contact-form-block">

                        <h2 class="contact-title text-black">Register</h2>

                        <form role="form" action="{{ route('register') }}" method="post" id="contact-forms">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" id="user_name" name="name" placeholder="Name"
                                       data-msg="Please Write Your Name"/>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" id="user_name" name="email" placeholder="Email"
                                       data-msg="Please Write Your Email"/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" id="user_name" name="password"
                                       placeholder="Password" data-msg="Please Write Your Password"/>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" id="user_name" name="password_confirmation"
                                       placeholder="Password Confirmation" data-msg="Please Confirm Your Password"/>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Account Type</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="account_type" id="account_donor"
                                           value="donor" checked>
                                    <label class="form-check-label" for="account_donor">Donor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="account_type"
                                           id="account_recipient" value="recipient">
                                    <label class="form-check-label" for="account_recipient">Recipient</label>
                                </div>
                                @error('account_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-custom">Register</button>
                            </div>

                        </form>

                        <div class="text-center">
                            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
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
