<!-- Recent News =================================================== -->
<section class="recent-news">

    <div class="page-container">

        <h2 class="heading--02 recent-news__title">{$recent_news_title}</h2>

        <a href="{$news_page_url}" title="View All News" class="recent-news__view-all-button button--purple">{$t.View_All}</a>

        <div class="flex-grid recent-news__grid">

            {foreach $posts as $post}

                <div class="box recent-news__item">
                    <span class="heading--05 recent-news__item-date">{$post->date}</span>
                    <span class="heading--05 recent-news__item-tag-list">
                        {if $post->tags}
                            {foreach from=$post->tags item=tag}
                                    <a href="{$news_page_url}?tag={$tag->slug}" title="{$tag->name}" class="recent-news__item-tag">{$tag->name}</a>
                            {/foreach}
                        {/if}
                    </span>
                    <h3 class="heading--03 recent-news__item-title">
                        <a href="{$post->url}" title="{$post->post_title}" class="recent-news__item-title-link">{$post->post_title}</a>
                    </h3>
                    <p class="recent-news__excerpt">{$post->excerpt}</p>
                    <a href="{$post->url}" title="{$post->post_title}" class="button--purple--small recent-news__item-link">{$t.Read_More}</a>
                    <hr>
                </div>

            {/foreach}

        </div>

    </div>

</section>
