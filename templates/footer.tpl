<div class="site_users">Пользователи на сайте за последние 24 часа:
	<div class="user_online">
	{foreach $user_on as $row }
		<a title="Последняя активность {$row.timeactive} назад" href="/profile/{$row.USER_NAME}"><font color="{$row.color}">{$row.USER_NAME}</font></a>
	{/foreach}
	</div>
	<div class="user_offline">
	{foreach $user_off as $row }
		<a title="Последняя активность {$row.timeactive} назад" href="/profile/{$row.USER_NAME}"><font color="{$row.color}">{$row.USER_NAME}</font></a>
	{/foreach}
	</div>
</div>
<div align="center" class="copyright">
	&copy;Copyright MorivVV <br/>
	2016 - {$ydate}</div>
</div>

</body>
</html>
{strip}