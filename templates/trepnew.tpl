{include file="sys/addCSS.tpl" css=array('trep','theme_trep','masonry')}

<div class="forumnav">
    <div class="parentforum"><a href="/forum">Список форумов</a></div>
    {foreach $topic_p as $trp }
        <div class="parentforum"><a href="/topic/{$trp.id}">{$trp.theme}</a></div>
    {/foreach}
</div> 

<div id='forumList'></div>

{assign var="next" value="0"}

<div id="messageList"></div>

<div id="previewimage" onclick="hidePicture()" ><img src=""></div>

{if $topic<>0}
    {include file='trep/newMessage.tpl'}
{/if}
<script>
 let user_id= {$user_id};
 let user= {$user};
 let topic= {$topic};
 let full= {$imsg};
 let current= {$str};
 let treptheme= {$jsontreptheme};
 let onPage= 15;
</script>
{include file="sys/addJS.tpl" js=array('gallery_masonry', 'smile','vue/trepTemplate','vue/smileTemplate')}

