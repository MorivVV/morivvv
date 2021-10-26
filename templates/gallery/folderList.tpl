<div class="gal_nav gal_next">
{foreach $folders as $fd}
	{if $fd.ID == $folder}
		<b> {$fd.NAIMEN_FOLDER} </b>
	{else}
		<a href="/gallery/{$tpl}-{$fd.ID}-0-{$step}-{$hdef}"> {$fd.NAIMEN_FOLDER} </a>
	{/if}
{/foreach}
<img onclick="addFolder(this)" style="height:25px" src="/image/system/add_plus.png" title="Добавить папку">
</div>