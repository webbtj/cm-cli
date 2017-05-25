<!-- Landing Featured Content ====================================== -->
<section class="landing-featured-content">

    <div class="page-container">

        <h1 class="heading--01 landing-featured-content__title">{$featured_content_title}</h1>

        <div class="flex-grid landing-featured-content__grid-wrapper">

            {foreach from=$featured_content_items item=featured_content_item}

                <a href="{$featured_content_item.cta.link}" target="{$featured_content_item.cta.target}" title="{$featured_content_item.cta.text}" class="box med-1of2 lg-1of3 landing-featured-content__item">
                    <div class="landing-featured-content__item-wrapper" style="background-image: url('{$featured_content_item.content_image.sizes.500x330}')">
                        <h4 class="heading--04 landing-featured-content__item-title">{$featured_content_item.cta.text}</h4>
                    </div>
                </a>

            {/foreach}

        </div>

    </div>

</section>
