<!-- Footer ======================================================== -->
<footer style="background-image: url('/mockup/assets/img/texture_footer.png')">

    <div class="contact__title-wrapper">

        <div class="page-container">
            <h1 class="heading--01 contact__title">{$contact_title}</h1>
        </div>

    </div>

    <div class="page-container flex-grid contact__wrapper">

        <div class="box lg-1of3 contact__copy-wrapper">
            <h5 class="heading--05 contact__name">{$address_title}</h5>
            <p class="contact__information">
                {$contact_address}
            </p>
        </div>

        <div class="box lg-2of3 contact__form">

            <!-- NOREX-NOTE: STYLE THIS. -->
            {$contact_form}

        </div>

    </div>

    <div class="copyright__wrapper">

        <div class="page-container">

            {if $secure_link}
                <a href="{$secure_link_url}" target="_blank" title="{$secure_link_name}" class="copyright__comodo-link">
                    <img src="{$secure_link_image.url}" alt="{$secure_link_name}">
                </a>
            {/if}

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
