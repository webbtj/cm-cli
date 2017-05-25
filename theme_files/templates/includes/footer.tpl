<!-- Footer ======================================================== -->
<footer>

    <div class="contact__title-wrapper">

        <div class="page-container">
            <h1>{$contact_title}</h1>
        </div>

    </div>

    <div class="page-container flex-grid">

        <div class="box lg-1of3">
            <h5>{$address_title}</h5>
            <p>
                {$contact_address}
            </p>
        </div>

        <div class="box lg-2of3">

        </div>

    </div>

    <div class="copyright__wrapper">

        <div class="page-container">

            <span class="copyright__float">
                <p>
                    {$t.Copyright} {$Y}
                    {if $privacy_policy_page}
                        |
                        <a href="{$privacy_policy_page->url}" title="{$privacy_policy_page->post_title}" class="copyright__privacy-policy-link">{$privacy_policy_page->post_title}</a>
                    {/if}
                </p>
            </span>

        </div>

    </div>

</footer>

<script data-main="{$stylesheet_directory}/assets/js/config" src="{$stylesheet_directory}/assets/js/require.js"></script>
