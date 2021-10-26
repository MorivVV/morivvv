{foreach $treptheme as $tr }
	<div class="topic_view" >
		<div class="topic" >
			<div class="topic_theme">
				<div class="theme"><a href="/topic/{$tr.id}">{$tr.theme}</a></div>
			</div>
			<div class="theme_info">
				<div class="count_post">{$tr.cnt}<a title='легкая текстовая версия' href="/topic/{$tr.id}----print"><img style='margin-left:5px; height:20px;' src='/image/system/txt.png'></a></div>
				<div class="last_autor">{$tr.pun}</div>
			</div>
			<div class="created">
				<div class="time">{$tr.tcreate}</div>
				<div class="autor"><a href="/profile/{$tr.USER_NAME}">{$tr.USER_NAME}</a></div>
			</div>
		</div>
		<div class="preview">
			<div class="trep_message">
				<div class="message_head">
					<div class="message_time">{$tr.tadd}</div>
				</div>
				<div class="user_info">
					<div class="user_name"><a href="/profile/{$tr.pun}">{$tr.pun}</a></div>
				</div>
				<div class="trep_text">{$tr.post}</div>
			</div>
		</div>
	</div>
{/foreach}