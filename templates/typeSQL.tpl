{include file="sys/addCSS.tpl" css=array('sql')}
{include file="sys/addJS.tpl" js=array('sqlqyery')}
Запрос вернул {$col} строк<br>
{if isset($headtable)}
<div class="table_scroll">
	<table border="1">
	<tr>
	{foreach from=$headtable item=h}
		<th>{$h}</th>
	{/foreach}
	{if $edt}
	<th>изменить</th>
	<th>удалить</th>
	{/if}
	<tr>
	{foreach from=$raw_query item=row}
	{counter assign="cntr"}
	<tr id="id{$cntr}">
		{foreach from=$row item=itm key=k}
			{if $show_tables[$table].pri eq $k}
				<td><span style="width: {10+7*($itm|count_characters:true)}px; font-size: 11px;" name="{$k}"  title="{htmlspecialchars($itm)}" >{htmlspecialchars($itm)}</span></td>
			{else}
				<td><input style="width: {10+7*($itm|count_characters:true)}px; font-size: 11px;" type="text" name="{$k}" title="{htmlspecialchars($itm)}" value="{htmlspecialchars($itm)}"/></td>
			{/if}
		{/foreach}
		{if $edt}
		<td><input onclick='CreateQueryUpdate("id{$cntr}","{$table}")' type='submit' value='изменить'/></td>
		<td><input onclick='CreateQueryDelete("id{$cntr}","{$table}")' type='submit' value='удалить'/></td>
		{/if}
	</tr>
	{/foreach}
	{if $edt}
	<tr id="add">
	{foreach from=$headtable item=h}
		<td><input style="width: 50px; font-size: 12px;" type="text" name="{$h}" value=""/></td>
	{/foreach}
	
	<td><input onclick='CreateQueryInsert("{$table}")' type='submit' value='добавить' /></td>
	<td></td>
	
	<tr>{/if}
	</table>
</div>
{/if}
{$sql} <input onclick='AddQuery(this)' name="{$sql}" type="submit" value="посмотреть последний запрос" />
<form id="sumb" action="/SQLQuery" method="post">
	<p><b>Запрос</b><br><textarea class="textadd" id="qstr" name="SQL" cols="100" rows="4" >{$sql}</textarea></p>
	<input hidden name="table" id="table_save" type="text" value="" />
	<p><input type="submit" value="Выполнить">   <input type="reset"></p>
</form>

<div class="tbl_block"><h2>Таблицы</h2>
{foreach from=$show_tables item=row}
    <div class="tbl_name">{$row.table}
	<input onclick="AddQuery(this)" name="SHOW COLUMNS FROM {$row.table}" type="submit" value="col" />
	<input onclick="AddQuery(this)" name="SELECT {$row.sel} FROM {$row.table} {$row.alias} ORDER BY {$row.pri} DESC LIMIT 0, 10" type="submit" value="data" /></div>
{/foreach}
<div class="tbl_name"><input type="text" value=""/>
	<input onclick="AddQuery(this)" name="CREATE TABLE {$row.table}" type="submit" value="add" />
	<input onclick="AddQuery(this)" name="SELECT {$row.sel} FROM {$row.table} {$row.alias} ORDER BY {$row.pri} DESC LIMIT 0, 10" type="submit" value="data" /></div>
</div>

{if isset($table_save)}
 <script type="text/javascript">
	document.getElementById('qstr').value="SELECT * FROM {$table_save} LIMIT 0, 30";
 </script>
{/if}