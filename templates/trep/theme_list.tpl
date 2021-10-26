<div class="forum_list" >
	<div class="theme_head">
		<div class="topic_theme">
			<div class="theme">Тема</div>
		</div>
		<div class="theme_info">
			<div class="count_post">сообщений{if $u_a}/прочитано{/if}</div>
			<div class="last_autor">последнее</div>
		</div>
		<div class="created">
			<div class="time">Создано</div>
			<div class="autor_theme">автор</div>
		</div>
	</div>

{foreach $treptheme as $tr }
	<div class="topic_view" >
		<div class="topic" >
			<div class="topic_theme">
				<div class="theme {if $tr.private}private{/if}"><a class="{if $tr.readTopic eq 0}novisit{elseif $tr.readTopic eq $tr.cnt}readall{else}visit{/if}" href="/topic/{$tr.id}">{$tr.theme}</a>{if $tr.child}вложеные форумы: {$tr.child}{/if}</div>
			</div>
			<div class="theme_info">
				<div class="count_post">{$tr.cnt}{if $u_a}/{$tr.readTopic}{/if}<a title='легкая текстовая версия' href="/topic/{$tr.id}----print"><img style='margin-left:5px; height:20px;' src='/image/system/txt.png'></a></div>
				<div class="last_autor"><a href="/post{$tr.id}---{$tr.pun}" title="{$tr.pst}">{$tr.pun}</a></div>
			</div>
			<div class="created">
				<div class="time">{$tr.tcreate}</div>
				<div class="autor_theme"><a href="/profile/{$tr.USER_NAME}">{$tr.USER_NAME}</a></div>
			</div>
		</div>

	</div>
{/foreach}
</div>