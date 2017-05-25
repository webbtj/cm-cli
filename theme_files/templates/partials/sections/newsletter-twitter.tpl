<!-- Newsletter & Twitter Feed ===================================== -->
<section class="newsletter-twitter">

    <div class="flex-grid">

        <!-- Newsletter Wrapper ==================================== -->
        <div class="box med-1of2 newsletter-twitter__newsletter-wrapper">

            <h3 class="heading--03 newsletter__title">{$newsletter_title}</h3>
            <p class="newsletter__copy">{$newsletter_description}</p>

            <!-- NOREX-NOTE: STYLE THIS. -->
            {$newsletter_form}

        </div>

        <!-- Twitter Wrapper ======================================= -->
        <div class="box med-1of2 newsletter-twitter__twitter-wrapper">

            <div class="newsletter-twitter__twitter-overflow-wrapper">
                <a class="twitter-timeline" href="https://twitter.com/{$twitter_user}">{$t.Tweets_by} {$twitter_user}</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>

        </div>

    </div>

</section>
