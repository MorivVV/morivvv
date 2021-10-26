<div class="trep_message">
    <div class="message_head">	
        <div class="message_time">{$tr.TIME_ADD}</div>
        <div class="message_number"><a href="/post{$tr.id_theme}--{$tr.UID}-{$tr.ID}">{$tr.ID}</a>
        {IF $user_id == $tr.UID || $user_level < $tr.KOD_RANK}
                <img onclick="changePost(this)" src="/image/system/pen.png" height="16px" title="редактировать сообщение" alt="{$tr.ID}" >
                <img onclick="deletePost(this)" src="/image/system/delete.gif" height="16px" title="удалить сообщение" alt="{$tr.ID}" >
        {/IF}
        </div>
    </div>
    <div class="user info" >
        <div class="user name"><a style="text-decoration: none" href="/profile/{$tr.USER_NAME}"><font color="{$tr.color}" face="Arial">{$tr.USER_NAME}</font></a></div>
        <div class="user rank">Сообщений:</div>
        <div class="user rank"><a href="/usermessage/--{$tr.UID}">{$tr.allPost} всего</a></div>
        <div class="user rank"><a href="/usermessage/{$tr.TID}--{$tr.UID}">{$tr.currentPost} в ветке</a></div>
        <div class="user avatar"><a href="/profile/{$tr.USER_NAME}"><img class="topic_caver" src="/img.php?tumbs={$tr.image}"></a></div>
        <div class="user rank"><font color="{$tr.color}" face="Arial">{$tr.RANK}</font></div>
        <div class="user rank"><input type="button" onclick="quotedPost(this)" id="{$tr.ID}" value="Ответить"/></div>
    </div>
    <div class="trep_text {if $tr.rd eq 0 and $user_id>0}noread{/if}" {IF $tr.LAST_ACTIVE < 500} style="background-image: url(/image/system/icon_user_online.gif)"{/IF}>
        {if $tr.KOD_QUOTED_POST>0}<div onclick="viewPost(this)" id="{$tr.KOD_QUOTED_POST}" class="message-quoted"><a >{$tr.KOD_QUOTED_POST} от {$tr.quser}</a>  </div>  {/if}        
            {$tr.POST}
            {if $tr.quoted>0}<div class="answer">{$tr.quoted}</div>{/if}
    </div>
</div>