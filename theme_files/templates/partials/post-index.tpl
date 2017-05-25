{foreach from=$posts item=post}
    <div class="flex-grid">

        <div class="box med-1of2 lg-2of5">
            <span>{$post->date}</span>
            <h3>
                <a href="{$post->url}" title="{$post->post_title}">{$post->post_title}</a>
            </h3>
        </div>

        <div class="box med-1of2 lg-3of5">
            {* //Show Taxonomies *}

            <!-- excerpt -->
            <p>{$post->excerpt}</p>
            <hr>
        </div>

    </div>
{/foreach}
{if !$posts}
    <section class="search-results__null-state">

        {$t.No_Results_Found}

    </section>
{/if}

{if $has_more}
    {include 'partials/sections/load-more.tpl'}
{/if}
