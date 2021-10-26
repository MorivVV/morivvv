<link rel='stylesheet' type='text/css' media="screen" href='/css/trep.css' />
<div class="user_info">
<h2>Поиск</h2>
<div>В Тексте сообщения<input type='text' id='stext' value='{$find_text}'\></div>
<div>В названии темы<input type='text' id='sforum' value='{$find_topic}'\></div>
<div>Имя пользователя<input type='text' id='suser' value='{$find_user}'\></div>
<div><input type='button' onClick='opensearch()' value='Найти'\></div>
</div>
<br>
{foreach $data as $tr }
<div class="trep_message">
	<div class="message_head">	
		<div class="message_time">{$tr.TIME_ADD}</div>
		<div class="message_time"><a href="/topic/{$tr.ID_THEME}">{$tr.theme}</a></div>
		<div class="message_number"><a href="/post{$tr.ID_THEME}--{$tr.UID}-{$tr.ID}">{$tr.ID}</a></div>
	</div>
	<div class="user_info" >
		<div class="user_name"><a style="text-decoration: none" href="/profile/{$tr.USER_NAME}"><font color="{$tr.color}" face="Arial">{$tr.USER_NAME}</font></a></div>
		<div class="user_avatar"><a href="/profile/{$tr.USER_NAME}"><img class="topic_caver" src="/img.php?tumbs={$tr.image}"></a></div>
	</div>
	<div class="trep_text" 
             {IF $tr.LAST_ACTIVE < 500} 
                 style="background-image: url(/image/system/icon_user_online.gif)"
             {/IF}>
            {$tr.POST}</div>
</div>
{/foreach}
<script src="/js/gallery_view.js"></script>
<script type="text/javascript" src="/js/smile.js"></script>
<script type="text/javascript">
function opensearch () {
var stext = document.getElementById("stext");
var sforum = document.getElementById("sforum");
var suser = document.getElementById("suser");

location.href="/search/"+stext.value+"-"+sforum.value+"-"+suser.value;
}
</script>
<div class="" name="" id=""></div>
