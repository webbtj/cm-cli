{foreach from=$posts item=post}

    <div id="posts" class="campaigns-index__item flex-grid">

        <div class="box med-1of4 lg-2of5 campaigns-index__item-image-wrapper">
            <img src="{$post->index_image.sizes.500x330}" alt="{$post->post_title}" class="campaigns-index__item-image">
        </div>

        <div class="box med-3of4 lg-3of5 campaigns-index__item-content-wrapper">
            <h2 class="heading--02 campaigns__index-title">
                <a href="{$post->url}" title="{$post->post_title}" class="campaigns-index__item-link">{$post->post_title}</a>
            </h2>
            <p>{$post->excerpt}</p>
            <a href="{$post->url}" title="{$post->post_title}" class="button--purple--small campaigns-index__item-read-more">{$t.Read_More}</a>
        </div>

    </div>
{/foreach}
{if !$posts}
    <section class="search-results__null-state">

        <h5 class="heading--05">{$no_filter_results}</h5>

    </section>
{/if}

{if $has_more}
    {include 'partials/sections/load-more.tpl'}
{/if}
