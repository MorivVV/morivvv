{include file="sys/addCSS.tpl" css=array('userchst')}
<span class="rooms">
    {for $i=1 to 10}
        {if $i eq $chat}
            Комната №{$i}
         {else}
        <a href="/userchat/{$i}">Комната №{$i}</a>
        {/if}
    {/for}
</span>
<div id = "connect">Нет подключения</div>
<div id = "ws-chat" value="{$chat}"></div>
<input id="message" type="text" value="Привет"/>
<input value="{$chat}" hidden="" type="text" id="chat"/>
        
<input id="user" type="text" value="MorivVV"/>
<input id="sendws" type="button" value="Отправить"/>

<audio id="player" src="/audio/z_uk-aska-z_uk.mp3"></audio>
{include file="sys/addJS.tpl" js=array('websocket')}