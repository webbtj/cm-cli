<!-- Navigation ==================================================== -->
<nav class="navigation--condensed">

    {if $main_menu}
        <!-- MOBILE TAB BAR -->
        <div class="navigation--condensed__tab-bar--mobile flex-grid">

            {foreach from=$main_menu item=item key=i}
                {if $i < 3}

                    {if $item->children}
                        <div class="navigation--condensed__tab-item box small-1of4" data-link-handler="submenu-{$item->ID}">
                            <a href="#" title="{$item->title}">{$item->title}</a>
                        </div>
                    {else}
                        <div class="navigation--condensed__tab-item box small-1of4">
                            <a href="{$item->url}" title="{$item->title}">{$item->title}</a>
                        </div>
                    {/if}

                {/if}
            {/foreach}

            {if $main_menu|@count > 2}
                <div class="navigation--condensed__tab-item box small-1of4" data-link-handler="submenu-mobile-more">
                    <a href="#" title="{$t.More}">{$t.More}</a>
                </div>
            {else}
                {if $languages}
                    {foreach from=$languages item=language}
                        {if !$language.active}
                            <div class="navigation--condensed__tab-item box small-1of4">
                                <a href="{$language.url}" title="{$language.native_name}">{$language.language_code}</a>
                            </div>
                        {/if}
                    {/foreach}
                {/if}
                <div class="navigation--condensed__tab-item box small-1of4">
                    <a href="#" title="{$t.Search}" data-link-handler="submenu-search">{$t.Search}</a>
                </div>
            {/if}

        </div>
    {/if}

    {if $main_menu}
        <!-- TABLET TAB BAR -->
        <div class="navigation--condensed__tab-bar--tablet flex-grid">
            {foreach from=$main_menu item=item key=i}
                {if $i < 5}
                    {if $item->children}
                        <div class="navigation--condensed__tab-item box small-1of6" data-link-handler="submenu-{$item->ID}">
                            <a href="#" title="{$item->title}">{$item->title}</a>
                        </div>
                    {else}
                        <div class="navigation--condensed__tab-item box small-1of6">
                            <a href="{$item->url}" title="{$item->title}">{$item->title}</a>
                        </div>
                    {/if}
                {/if}
            {/foreach}

            {if $main_menu|@count > 4}
                <div class="navigation--condensed__tab-item box small-1of6" data-link-handler="submenu-tablet-more">
                    <a href="#" title="More">More</a>
                </div>
            {else}
                {if $languages}
                    {foreach from=$languages item=language}
                        {if !$language.active}
                            <div class="navigation--condensed__tab-item box small-1of6">
                                <a href="{$language.url}" title="{$language.native_name}">{$language.language_code}</a>
                            </div>
                        {/if}
                    {/foreach}
                {/if}
                <div class="navigation--condensed__tab-item box small-1of6">
                    <a href="#" title="{$t.Search}" data-link-handler="submenu-search">{$t.Search}</a>
                </div>
            {/if}

        </div>
    {/if}

    {if $main_menu|@count > 3}
        <div class="navigation--condensed__submenu" data-link-target="submenu-mobile-more">
            <div class="navigation--condensed__submenu-close" data-link-handler="submenu-mobile-more"><i class="ionicons ion-android-close"></i>{$t.Back}</div>
            {foreach from=$main_menu item=item key=i}
                {if $i >= 3}
                    <a href="{$item->url}" title="{$item->title}" class="navigation--condensed__submenu-item">
                        {$item->title}
                        {if $item->children}
                            <i class="ionicons ion-plus" data-link-handler="submenu-{$item->ID}"></i>
                        {/if}
                    </a>
                {/if}
            {/foreach}
            {if $languages}
                {foreach from=$languages item=language}
                    {if !$language.active}
                        <a href="{$language.url}" title="{$language.native_name}" class="navigation--condensed__submenu-item">{$language.language_code}</a>
                    {/if}
                {/foreach}
            {/if}
            <a href="#" title="{$t.Search}" class="navigation--condensed__submenu-item" data-link-handler="submenu-search">{$t.Search}</a>
        </div>
    {/if}

    {if $main_menu|@count > 4}
        <div class="navigation--condensed__submenu" data-link-target="submenu-tablet-more">
            <div class="navigation--condensed__submenu-close" data-link-handler="submenu-tablet-more"><i class="ionicons ion-android-close"></i>{$t.Back}</div>
            {foreach from=$main_menu item=item key=i}
                {if $i >= 5}
                    <a href="{$item->url}" title="{$item->title}" class="navigation--condensed__submenu-item">
                        {$item->title}
                        {if $item->children}
                            <i class="ionicons ion-plus" data-link-handler="submenu-{$item->ID}"></i>
                        {/if}
                    </a>
                {/if}
            {/foreach}
            {if $languages}
                {foreach from=$languages item=language}
                    {if !$language.active}
                        <a href="{$language.url}" title="{$language.native_name}" class="navigation--condensed__submenu-item">{$language.language_code}</a>
                    {/if}
                {/foreach}
            {/if}
            <a href="#" title="{$t.Search}" class="navigation--condensed__submenu-item" data-link-handler="submenu-search">{$t.Search}</a>
        </div>
    {/if}

    {foreach from=$main_menu item=item}
        {if $item->children}
            <div class="navigation--condensed__submenu" data-link-target="submenu-{$item->ID}">
                <div class="navigation--condensed__submenu-close" data-link-handler="submenu-{$item->ID}"><i class="ionicons ion-android-close"></i>{$t.Back}</div>
                <a href="{$item->url}" title="{$item->title}" class="navigation--condensed__submenu-item">{$item->title}</a>
                {foreach from=$item->children item=child}
                    <a href="{$child->url}" title="{$child->title}" class="navigation--condensed__submenu-item">{$child->title}</a>
                {/foreach}
            </div>
        {/if}
    {/foreach}

    <div class="navigation--condensed__submenu" data-link-target="submenu-search">
        <div class="navigation--condensed__submenu-close" data-link-handler="submenu-search"><i class="ionicons ion-android-close"></i>{$t.Back}</div>
        <form method="get" action="/" class="navigation--condensed__search-form">
            <input type="text" name="s" class="navigation--condensed__search-input">
            <a href="#" title="{$t.Search}" id="search-anchor-mobile" class="navigation--condensed__search-submit button--blue--small"><i class="ionicons ion-ios-search"></i> Search</a>
        </form>
    </div>


</nav>
