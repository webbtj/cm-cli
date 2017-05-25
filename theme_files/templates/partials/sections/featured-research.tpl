<!-- Featured Research ============================================= -->
<!-- NOREX-NOTE: NEED A TITLE. -->
<!-- {$featured_research_title} -->
<section class="featured-research">

    <div class="flex-grid">

        {foreach from=$featured_research item=featured_research_item}
            <div class="box lg-1of3 featured-research__item">
                <div class="featured-research__item-wrapper">
                    <span class="heading--06 featured-research__item-date">{$featured_research_item->date}</span>

                    {if $featured_research_item->tags}
                        <span class="heading--06 featured-research__item-tag-wrapper">
                            {foreach from=$featured_research_item->tags item=tag}
                                <a href="?tag={$tag->slug}" title="{$tag->name}" class="featured-research__item-tag">{$tag->name}</a>
                            {/foreach}
                        </span>
                    {/if}

                    <h2 class="heading--02 featured-research__item-title">
                        <a href="{$featured_research_item->url}" title="{$featured_research_item->post_title}" class="featured-research__item-title-link">{$featured_research_item->post_title}</a>
                    </h2>
                    <p>{$featured_research_item->excerpt}</p>

                    {if $featured_research_item->cta}
                        <a href="{$featured_research_item->cta.link}"
                            target="{$featured_research_item->cta.target}"
                            title="{$featured_research_item->cta.text}"
                            class="button--blue featured-research__item-download-button">{$featured_research_item->cta.text}</a>
                    {/if}
                </div>
            </div>
        {/foreach}

    </div>

</section>
