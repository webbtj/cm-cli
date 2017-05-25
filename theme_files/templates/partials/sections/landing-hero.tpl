<!-- Landing Hero ================================================== -->
<section class="landing-hero">

    <a href="/" title="{$t.Go_to_the_CFNU_Landing_Page}" class="landing-hero__logo-wrapper">
        <img src="/mockup/assets/img/{$t.logo_horizontal_white_png}" alt="{$t.The_CFNU_Logo}">
    </a>

    <div class="landing-hero__carousel-wrapper">

        {foreach from=$banners item=banner}
            <!-- NOREX-NOTE: THIS ANCHOR NEEDS TO BE STYLED -->

            <!-- style="background-image: url('{$banner_image.sizes.1920x1282}')" -->

            <a class="landing-hero__item"
                href="{$banner.banner_cta.link}"
                target="{$banner.banner_cta.target}"
                title="{$banner.banner_text}"
                style="background-image: url('{$banner.banner_image.sizes.1920x1282}')">

                <div class="flex-grid">

                    <div class="box med-1of2 lg-3of5"></div>

                    <div class="box med-1of2 lg-2of5 landing-hero__item-content-wrapper">

                        <h1 class="heading--01 landing-hero__item-title">{$banner.banner_text}</h1>
                        <h4 class="heading--04 landing-hero__item-subtitle">{$banner.banner_subtitle}</h4>

                    </div>

                </div>

            </a>
        {/foreach}

    </div>

</section>
