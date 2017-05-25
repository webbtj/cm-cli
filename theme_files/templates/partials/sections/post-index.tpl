<!-- Post Index ==================================================== -->
<section class="post-index">

    <div class="content-container">

        <div>

            <div class="flex-grid">

                {* //Filter Taxonomies *}

                {if $years}
                    <div class="box med-1of3">
                        <label for="post-year">{$t.Filter_by_Year}</label>
                        <div class="select-wrapper">
                            <select id="post-year">
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
                            <select id="post-month">
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

            <div id="posts">

                {include file="partials/posts.tpl"}

            </div>

        </div>

    </div>

</section>
