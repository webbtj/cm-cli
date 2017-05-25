{foreach from=$posts item=post}
    <div class="flex-grid research-index__item">

        <div class="box med-1of2 lg-2of5 research-index__item-meta-wrapper">
            <span class="heading--06 research-index__item-date">{$post->date}</span>
            <h3 class="heading--03 research-index__item-title">
                <a href="{$post->url}" title="ANCHOR TITLE" class="research-index__item-title-link">{$post->post_title}</a>
            </h3>
            {if $post->cta}
                <a href="{$post->cta.link}" target="{$post->cta.target}" title="{$post->cta.text}" class="button--purple--small research-index__item-download-button">{$post->cta.text}</a>
            {/if}
        </div>

        <div class="box med-1of2 lg-3of5 research-index__item-copy-wrapper">
            {if $post->tags}
                <span class="heading--06 research-index__item-tag-wrapper">
                    {foreach from=$post->tags item=tag}
                        <a href="?tag={$tag->slug}" title="{$tag->name}" class="research-index__item-tag">{$tag->name}</a>
                    {/foreach}
                </span>
            {/if}
            <p class="research-index__item-copy">{$post->excerpt}</p>
            {if $post->cta}
                <a href="{$post->cta.link}" target="{$post->cta.target}" title="{$post->cta.text}" class="button--purple--small research-index__item-download-button--mobile">{$post->cta.text}</a>
            {/if}
            <hr>
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
