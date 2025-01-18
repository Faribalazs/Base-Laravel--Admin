<div class="footer-bg w-100">
    <div class="flex flex-row flex-wrap justify-around content-div">
        <div class="mt-4 links">
            <span class="footer-title">{{ __('app.footer.informations') }}</span>
            <div class="flex flex-col">
                <div class="pt-3"><a href="{{ route('about.us') }}" class="footer-category-text">{{ __('app.about-us.about-us-title') }}</a></div>
                <div class="pt-3"><a href="#" class="footer-category-text">Link1</a></div>
                <div class="pt-3"><a href="#" class="footer-category-text">Link2</a></div>
              </div>
        </div>
        <div class="mt-4 links">
            <span class="footer-title">{{ __('app.footer.contacts') }}</span>
            <div class="flex flex-col text-left mt-3">
                <div class="pt-1 flex media-text ">
                    <div class="flex align-center">
                        <i class="ri-phone-fill phone-icon"></i>
                    </div>
                    <div class="flex align-center">
                        <a href="tel:{{ config('app.phone_number') }}" class="footer-category-text pl-3">{{ config('app.phone_number') }}</a>
                    </div>
                </div>
                <div class="pt-3 flex media-text">
                    <div class="flex align-center">
                        <i class="ri-mail-fill phone-icon"></i>
                    </div>
                    <div class="flex align-center">
                        <a href="mailto:{{ config('app.email') }}" class="footer-category-text pl-3">{{ config('app.email') }}</a>
                    </div>
                </div>
              </div>
        </div>
        <div class="mt-4 pr-3">
            <span class="footer-title">{{ __('app.footer.social-media') }}</span>
            <div class="flex flex-col">
                <div class="pt-1 flex justify-between media-align">
                    <div class="flex align-center">
                        <i class="ri-facebook-circle-fill social-icon"></i>
                    </div>
                    <div class="flex align-center">
                        <i class="ri-instagram-fill social-icon"></i>
                    </div>
                    <div class="flex align-center">
                        <i class="ri-linkedin-box-fill social-icon"></i>
                    </div>
                </div>
              </div>
        </div>
    </div>
    <span class="copyright px-4 sm:px-6 lg:px-12">Copyright © {{ date("Y") }} {{ __('app.basic.app_name') }} {{ __('app.footer.all-rights-reserved') }}</span>
</div>
