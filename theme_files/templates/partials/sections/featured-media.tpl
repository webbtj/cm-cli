<!-- Featured Photo or Video ======================================= -->
<section class="featured-media">

    <div class="content-container">

        {if $featured_image}
            <img src="{$featured_image.sizes.960w}" alt="{$title}" class="featured-media__image">
        {/if}

        {if $featured_video}
            <div class="featured-media__video-wrapper">
                <iframe width="560" height="315" src="{$featured_video}" frameborder="0" allowfullscreen></iframe>
            </div>
        {/if}

    </div>

</section>
