<div class="newsletterRegistration" >

    <h1 class="text-center">{{ trans('billing::newsletter.registration.title') }}</h1>

    <div class="form-group has-success col-sm-6 col-sm-offset-3">

        <form action="{{ route('newsletter.send.confirmation') }}" method="post">
            {{ csrf_field() }}

            <label class="control-label" for="inputSuccess">{{ trans('billing::newsletter.registration.email') }}</label>
            <div class="input-group">
                <input class="form-control" type="text" name="email">

                <span class="input-group-btn">

                    <?php /*
                    <button
                            class="g-recaptcha"
                            data-sitekey="6LdTyiYUAAAAAKbhpq-JdqXHJ9_2K1sG7KctXy7C"
                            data-callback="YourOnSubmitFn">
                            {{ trans('billing::newsletter.registration.confirm') }}
                    </button>*/ ?>

                    <button class="btn btn-default" type="submit">
                        {{ trans('billing::newsletter.registration.confirm') }}
                    </button>



                </span>
            </div>

            <div class="input-group">
                <div class="g-recaptcha" data-sitekey="6LcYzyYUAAAAAC7ZZtQA64rhJKT_BmoxaTftgC32"></div>
            </div>

        </form>



    </div>
</div>