<!-- News Index ==================================================== -->
<section class="news-index">

    <div class="content-container">

        <div class="news-index__grid-wrapper">

            <div class="news-index__filter-wrapper flex-grid">

                {if $filter_tags}
                    <div class="box med-1of3">
                        <label for="post-tag">{$t.Filter_by_Tag}</label>
                        <div class="select-wrapper">
                            <select id="post-tag" class="news-index__select">
                                <option value="">{$t.All}</option>
                                {foreach from=$filter_tags item=tag}
                                    {if $tag->selected}
                                        <option selected value="{$tag->slug}">{$tag->name}</option>
                                    {else}
                                        <option value="{$tag->slug}">{$tag->name}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                    </div>
                {/if}

                {if $years}
                    <div class="box med-1of3">
                        <label for="post-year">{$t.Filter_by_Year}</label>
                        <div class="select-wrapper">
                            <select id="post-year" class="news-index__select">
                                <option value="">{$t.All}</option>
                                {foreach from=$years item=year}
                                    <option value="{$year}">{$year}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                {/if}

                {if $months}
                    <div class="box med-1of3">
                        <label for="post-month">{$t.Filter_by_Month}</label>
                        <div class="select-wrapper">
                            <select id="post-month" class="news-index__select">
                                <option value="">{$t.All}</option>
                                {foreach from=$months item=month key=i}
                                    <option value="{$i}">{$month}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                {/if}

            </div>

            <input type="hidden" id="post-type" value="{$post_type}">
            <input type="hidden" id="post-page" value="1">

            <div id="posts" class="news-index__wrapper">

                {if $post_type == 'cfnu_research'}
                    {include file="partials/cfnu_research.tpl"}
                {else}
                    {include file="partials/posts.tpl"}
                {/if}

            </div>

        </div>

    </div>

</section>
