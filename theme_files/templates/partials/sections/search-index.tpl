<!-- Research Index ================================================ -->
<section class="search-index">

    <div class="content-container">

        {if $posts}

            <div class="search-index__grid-wrapper">

                <div class="news-index__wrapper">

                    {foreach from=$posts item=post}
                        <div class="news-index__item">
                            <span class="heading--05 news-index__item-date">{$post->date}</span>

                            <span class="heading--05 news-index__item-tag-wrapper">
                                {foreach from=$post->tags item=tag}
                                    {if $index_page_url}
                                        <a href="{$index_page_url}?tag={$tag->slug}" title="{$tag->name}" class="news-index__item-tag">{$tag->name}</a>
                                    {/if}
                                {/foreach}
                            </span>
                            <h2 class="heading--02 news-index__item-title">
                                <a href="{$post->url}" title="{$post->post_title}" class="news-index__item-title-link">{$post->post_title}</a>
                            </h2>
                            <p>{$post->excerpt}</p>
                            <a href="{$post->url}" title="{$post->post_title}" class="button--purple--small news-index__item-read-button">{$t.Read_More}</a>
                            <hr>
                        </div>
                    {/foreach}



                </div>

            </div>

        {else}

            <section class="search-results__null-state">

                <h5 class="heading--05">{$no_search_results}</h5>

            </section>

        {/if}

    </div>

</section>
