
<!-- Media Index =================================================== -->
<section class="media-index">

    <div class="flex-grid top">

        {if $photo_gallery}
            <div class="box lg-3of4 flex-grid media-index__photo-gallery">

                <div class="box full media-index__gallery-title-wrapper">
                    <h2 class="heading--02 media-index__gallery-title">{$photo_gallery_title}</h2>
                </div>

                {foreach from=$photo_gallery item=photo_gallery_item}
                    <div class="box med-1of2 lg-1of3 media-index__gallery-item">
                        <a href="{$photo_gallery_item.image.sizes.600w}" target="_blank" title="Download {$photo_galler_item.title} Low-Res" class="media-index__gallery-item-link">
                            <img src="{$photo_gallery_item.image.sizes.500x500}" alt="{$photo_gallery_item.title}" class="media-index__gallery-item-image">
                            <h5 class="heading--05 media-index__gallery-item-title">{$photo_gallery_item.title}</h5>
                        </a>
                        <a href="{$photo_gallery_item.image.sizes.600w}" target="_blank" title="{$photo_galler_item.title} - {$t.Download_Low_Res}" class="media-index__download-button">{$t.Download_Low_Res}</a>
                        <a href="{$photo_gallery_item.image.url}" target="_blank" title="{$photo_galler_item.title} - {$t.Download_Hi_Res}" class="media-index__download-button">{$t.Download_Hi_Res}</a>
                    </div>
                {/foreach}

            </div>
        {/if}

        {if $press_kit_items}

            <div class="box lg-1of4 flex-grid media-index__press-kit">

                <hr>

                <h2 class="heading--02 box full media-index__press-title">{$press_kit_title}</h2>

                {foreach from=$press_kit_items item=press_kit_item}
                    <h5 class="heading--05 box med-1of2 lg-full media-index__press-kit__item">
                        <a href="{$press_kit_item.link}" title="{$press_kit_item.text}" target="{$press_kit_item.target}" class="button--purple media-index__press-kit__item-link">{$press_kit_item.text}</a>
                    </h5>
                {/foreach}

            </div>

        {/if}

    </div>

</section>
