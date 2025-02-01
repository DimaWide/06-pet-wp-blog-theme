<?php


?>
<div class="cmp-4-popup mod-subscribe-popup" data-id="subscribe-popup">
    <div class="cmp4-overlay"></div>
    <div class="cmp4-inner-out">
        <div class="cmp4-inner" id="subscribe-popup">

            <div class="cmp4-close js-close">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/menu-btn-close.svg'; ?>" alt="img">
            </div>

            <div class="acf-5-contact-us newsletter">
                <div class="data-inner">
                    <div class="data-b1">
                        <h2 class="data-title">
                            Stay connected — get the latest news!
                        </h2>

                        <div class="data-subtitle">
                            Subscribe to our newsletter to stay updated on new promotions, offers, and important updates. We won't bother you with unnecessary emails — only the most important news.
                        </div>

                        <form action="/" method="POST" class="data-form newsletter-form">
                            <input type="email" name="email" placeholder="Enter your email" required>

                            <div class="data-form-field checkbox-wrapper">
                                <input type="checkbox" id="newsletter-agree" name="agree" required>
                                <label for="newsletter-agree">
                                    <span>I agree to receive the newsletter.</span>
                                </label>
                            </div>

                            <div class="data-form-submit">
                                <button type="submit" class="cmp-button-two">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>