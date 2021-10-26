{include file="sys/addCSS.tpl" css=array('trep','theme_trep','masonry')}

<div class="forumnav">
    <div class="parentforum"><a href="/forum">Список форумов</a></div>
    {foreach $topic_p as $trp }
        <div class="parentforum"><a href="/topic/{$trp.id}">{$trp.theme}</a></div>
    {/foreach}
</div>
        
{if $treptheme}
    {include file='trep/theme_list.tpl' treptheme=$treptheme}
{/if}

{include file='trep/pageTopic.tpl' current=$str full=$imsg onPage=15 topic=$topic}

{assign var="next" value="0"}
<div class="messageBlock">
    {foreach $newtrepdata as $tr }
        {include file="trep/trep_message.tpl"}
        {assign var="next" value=$tr.nextPo}
    {/foreach}
    <div onclick="nextPost(this)" id="{$next}" class="message-quoted">ЕЩЕ</div>
</div>

{include file='trep/pageTopic.tpl' current=$str full=$imsg onPage=15 topic=$topic}

<div id="previewimage" onclick="hidePicture()" ><img src=""></div>
{if $topic<>0}
    {include file='trep/newMessage.tpl'}
{/if}

{include file="sys/addJS.tpl" js=array('smile','gallery_masonry')}