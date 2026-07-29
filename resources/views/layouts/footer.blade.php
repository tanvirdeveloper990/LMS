<footer class="site-footer">
    <div class="container">

        <!-- Company Info & Social — visible only on mobile, centered -->
        <div class="d-lg-none mb-5 text-center">
            <div class="footer-logo-box mx-auto mb-4">
                <a href="/">
                    <img src="{{ Storage::url($setting->footer_logo) }}"
                        alt="{{ $setting->company_name }}">
                </a>
            </div>
            <h4 class="social-title">Follow Us</h4>
            <div class="social-icons justify-content-center">
                @if($setting->facebook)
                <a href="{{ $setting->facebook }}" class="social-facebook" aria-label="Facebook"><i
                        class="fab fa-facebook-f"></i></a>
                @endif
                @if($setting->youtube)
                <a href="https://youtube.com/shorts/G2LlA4t3icg?si=J5Z4dHo5z44JeqDZ" class="social-youtube"
                    aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                @endif
                @if($setting->instagram)
                <a href="https://www.instagram.com/multibrand24/" class="social-instagram" aria-label="Instagram"><i
                        class="fab fa-instagram"></i></a>
                @endif
                @if($setting->tiktok)
                <a href="https://www.tiktok.com" class="social-tiktok" aria-label="TikTok"><i
                        class="fab fa-tiktok"></i></a>
                @endif
            </div>
        </div>

        <div class="row gy-5">

            <!-- Company Info — desktop only -->
            <div class="col-lg-2 d-none d-lg-block">
                <div class="footer-logo-box mb-4">
                    <a href="/">
                        <img src="{{ Storage::url($setting->footer_logo) }}"
                            alt="{{ $setting->company_name }}">
                    </a>
                </div>
                <h4 class="social-title">Follow Us</h4>
                <div class="social-icons">
                    @if($setting->facebook)
                    <a href="{{ $setting->facebook }}" class="social-facebook" aria-label="Facebook"><i
                            class="fab fa-facebook-f"></i></a>
                    @endif
                    @if($setting->youtube)
                    <a href="https://youtube.com/shorts/G2LlA4t3icg?si=J5Z4dHo5z44JeqDZ" class="social-youtube"
                        aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if($setting->instagram)
                    <a href="https://www.instagram.com/multibrand24/" class="social-instagram"
                        aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if($setting->tiktok)
                    <a href="https://www.tiktok.com" class="social-tiktok" aria-label="TikTok"><i
                            class="fab fa-tiktok"></i></a>
                    @endif
                </div>
            </div>

            <!-- Top Categories -->
            @php
            $topCategories = \App\Models\Category::latest()->take(5)->get();
            @endphp
            <div class="col-6 col-lg-2 d-none d-lg-block text-center text-md-start">
                <h3 class="footer-heading">Top Categories</h3>
                <ul class="footer-links">
                    @forelse($topCategories as $category)
                    <li><a href="{{ route('products', ['category' => $category->id]) }}"><i
                                class="fas fa-angle-right"></i><span>{{$category->name}}</span></a></li>
                    @empty
                    <li><a href="#"><i
                                class="fas fa-angle-right"></i><span>No categories available</span></a></li>
                    @endforelse

                </ul>
            </div>

            <!-- Quick Navigation -->
            <div class="col-6 col-lg-2 text-center text-md-start">
                <h3 class="footer-heading">Quick Navigation</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('about-us') }}"><i class="fas fa-angle-right"></i><span>About
                                Us</span></a></li>
                    <li><a href="{{ route('how.to.buy') }}"><i class="fas fa-angle-right"></i><span>How to
                                Buy</span></a></li>
                    <li><a href="{{ route('reviews') }}"><i class="fas fa-angle-right"></i><span>Customer
                                Reviews</span></a></li>
                    <li><a href="{{ url('complaint') }}"><i class="fas fa-angle-right"></i><span>Submit a
                                Complaint</span></a></li>
                    <li><a href="{{ route('contacts') }}"><i class="fas fa-angle-right"></i><span>Contact
                                Us</span></a></li>
                </ul>
            </div>

            <!-- Legal & Policy -->
            <div class="col-6 col-lg-2 text-start">
                <h3 class="footer-heading">Legal &amp; Policy</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('delivery-policy') }}"><i
                                class="fas fa-angle-right"></i><span>Delivery Policy</span></a></li>
                    <li><a href="{{ route('return-policy') }}"><i
                                class="fas fa-angle-right"></i><span>Return Policy</span></a></li>
                    <li><a href="{{ route('refund-policy') }}"><i
                                class="fas fa-angle-right"></i><span>Refund Policy</span></a></li>
                    <li><a href="{{ route('warranty-policy') }}"><i
                                class="fas fa-angle-right"></i><span>Warranty Policy</span></a></li>
                    <li><a href="{{ route('privacy-policy') }}"><i
                                class="fas fa-angle-right"></i><span>Privacy Policy</span></a></li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="col-6 col-lg-4 text-center text-lg-start footer-contact-col">
                <h3 class="footer-heading">Contact Information</h3>

                <div class="contact-item">
                    <div class="contact-icon phone"><i class="fas fa-phone"></i></div>
                    <div>
                        <p class="label">Number:</p>
                        <a href="tel:{{ $setting->phone_one }}">{{ $setting->phone_one }}</a>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon mail"><i class="fas fa-envelope"></i></div>
                    <div>
                        <p class="label">Email:</p>
                        <a href="mailto:{{ $setting->email_one }}">{{ $setting->email_one }}</a>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon map"><i class="fas fa-location-dot"></i></div>
                    <div>
                        <p class="label">Address:</p>
                        <p class="value mb-0">{{ $setting->address }}</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <p class="mb-0">Copyright © {{date('Y')}} <span>{{ $setting->copyright }}</span>. All rights reserved.</p>
        </div>

    </div>
</footer>