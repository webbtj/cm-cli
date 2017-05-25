<!-- Search Index ================================================ -->
<section class="search-index">

    <div class="content-container">

        {if $posts}

            <div>

                <div>

                    {foreach from=$posts item=post}
                        <div>
                            <span>{$post->date}</span>
                            {* //Show Taxonomies *}

                            <p>{$post->excerpt}</p>
                            <a href="{$post->url}" title="{$post->post_title}">{$t.Read_More}</a>
                            <hr>
                        </div>
                    {/foreach}

                </div>

            </div>

        {else}

            <section class="search-results__null-state">

                {$t.No_Results_Found}

            </section>

        {/if}

    </div>

</section>
