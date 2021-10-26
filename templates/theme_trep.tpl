{include file="sys/addCSS.tpl" css=array('theme_trep','trep')}

{include file='trep/pageTopic.tpl' current=$str full=$foruminfo.usertheme onPage=50 topic=$topic}

<div id='forumList'></div>

{if $u_a and $topic==0} {include file='trep/newMessage.tpl'} {/if}

<script>
    let user_id= {$user_id},
        topic= {$topic},
        full=0,
        onPage=0,
        treptheme= {$jsontreptheme}
</script>

{include file="sys/addJS.tpl" js=array('smile','vue/trepTemplate','vue/smileTemplate')}

<div class="topic_view" >
    <div class="topic_theme">
			<h2>Статистика форума</h2>
		</div>
    <div class="topic_theme">Всего тем<div class="created">{$foruminfo.alltheme}</div></div>
    <div class="topic_theme">Всего сообщений<div class="created">{$foruminfo.allmsg}</div></div>
    <div class="topic_theme">Всего посты оставило <div class="created">{$foruminfo.users} пользователей</div></div>
</div>
