<div class="forumnav">
	<div class="parentforum"><a href="/forum">Список форумов</a></div>
	{foreach $topic_p as $trp }
		<div class="parentforum"><a href="/topic/{$trp.id}">{$trp.theme}</a></div>
	{/foreach}
</div>
<br/>
<div class="topic-page">
	Страницы для печати:
	{foreach $allmsg as $tr }
		<span class="page">{$tr}</span>
	{/foreach}
</div>
<br/>
<hr />
{assign var="varName" value=''}
{assign var="varTime" value=''}
{foreach $newtrepdata as $tr }
<div class="trep_message">
	{IF $tr.TM_ADD|date_format:"%d-%m-%Y" <> $varTime}
		{assign var="varTime" value=($tr.TM_ADD|date_format:"%d-%m-%Y")}
		<hr />{$varTime}<hr />
	{/if}
	{IF $varName  <> $tr.USER_NAME}
	{assign var="varName" value=$tr.USER_NAME}
	<b {IF $tr.LAST_ACTIVE < 500} style="background: palegreen"{/IF}><a style="text-decoration: none" href="/profile/{$tr.USER_NAME}"><font color="{$tr.color}" face="Arial">{$tr.USER_NAME}</font></a></b>
	{/if}
	
	<i style='font-size:0.7rem; margin-left: 10px'>
	
	{$tr.TM_ADD|date_format:"%H:%M:%S"}
	</i>
	<div style='margin-left: 10px'>{$tr.POST}</div>
</div>
<hr />
{/foreach}
<div class="topic-page">
	{foreach $allmsg as $tr }
		<span class="page">{$tr}</span>
	{/foreach}
</div>
{if $topic<>0}
<form action="/sendpost" method="post">
	<p><b>Сообщение</b>
	{$smiles}
	<textarea class="textadd" required name="POST" id="posttext" cols="80" rows="3"></textarea></p>
	<p><input type="hidden" name="topic" value="{$topic}" ><input type="submit">   <input type="reset"></p>
</form>
{else}
<div></div>
{/if}

{include file="sys/addJS.tpl" js=array('smile','gallery_masonry')}