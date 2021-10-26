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

{assign var="next" value="0"}
{literal}
<div id="messageList" class="messageBlock">
</div>
{/literal}
<div id="previewimage" onclick="hidePicture()" ><img src=""></div>
{if $topic<>0}
    {include file='trep/newMessage.tpl'}
{/if}

{include file="sys/addJS.tpl" js=array('gallery_masonry', 'smile')}
<script>
import forumMessage from '/vue/forumMessage.vue';
    {literal}
    let comp = {
        template: 
        ``,
        data() {
            return { {/literal}
            user_id: {$user_id},
            topic: {$topic},
            tpl: 'new',
            full: {$imsg},
            current: {$str},
            onPage: 15 {literal}
}
        
        }};
        
    let v = new Vue({
        el: '#messageList',
        data() {return { {/literal}
            jsontrepdata: {$jsontrepdata},
            user_id: {$user_id},
            topic: {$topic},
            tpl: 'new'
 {literal}       }},
        components: {
           forumMessage
        }
    }){/literal}
</script>
