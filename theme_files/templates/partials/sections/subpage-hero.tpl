<!-- Subpage Hero ================================================== -->
<section class="subpage-hero" style="background-image: url('{$header_image.sizes.1920x1080}')">

    <div class="content-container">

        <a href="/" title="{$t.Go_to_the_CFNU_Landing_Page}" class="subpage-hero__logo-wrapper">
            <img src="/mockup/assets/img/{$t.logo_horizontal_white_png}" alt="{$t.The_CFNU_Logo}">
        </a>

        {if $date}
            <h5 class="heading--05 subpage-hero__date">{$date}</h5>
        {/if}

        <h1 class="heading--01 subpage-hero__title">{$title}</h1>

        {if $tags}
            <span class="subpage-hero__tag-wrapper">

                {foreach from=$tags item=tag}
                    {if $index_page_url}
                        <h5 class="heading--05 subpage-hero__tag">
                            <a href="{$index_page_url}?tag={$tag->slug}" title="{$tag->name}" class="subpage-hero__tag-link">{$tag->name}</a>
                        </h5>
                    {/if}
                {/foreach}

            </span>
        {/if}

        {if $cta && $cta_top}

            <br>

            <a href="{$cta.link}" title="{$cta.text}" target="{$cta.target}" class="button--purple subpage-hero__cta">{$cta.text}</a>

        {/if}

    </div>

</section>
