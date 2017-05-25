<!-- Research Index ================================================ -->
<section class="research-index">

    <div class="content-container">

        <div class="research-index__grid-wrapper">

            <div class="flex-grid research-index__heading-wrapper">
                <h1 class="heading--01 research-index__title">{$all_research_title}</h1>
                {if $filter_tags}
                    <div class="box med-1of2 research-index__filter-wrapper">
                        <label for="post-tag" class="research-index__filter-label">{$t.Filter_by_Tag}</label>
                        <div class="select-wrapper">
                            <select class="research-index__filter" id="post-tag">
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

                {include file="partials/cfnu_research.tpl"}

            </div>

        </div>

    </div>

</section>
