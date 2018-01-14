<div class="clearfix" style="height: 30px"></div>

<div class="container">
    <hr/>
    <div class="text-list-wrap">
        {foreach $links as $link}
            <a href="{$SEARCH_URL}?url_id={$link.id}" title="{$link.url}">{$link.text}</a>
        {/foreach}
    </div>
</div>
