<link rel='stylesheet' type='text/css' media="screen" href='/css/sudoku.css' />
<table class = "sudoku-table">
	<tr class = "sudoku-line">
{foreach from=$sudoku item=tr key=i}
	{if $tr>0}
	<td class = "sudo basic" id="sudo-{$i}">{$tr}</td>
	{else}
	<td class = "sudo answer" id="sudo-{$i}"></td>
	{/if}
	
	{if $i%9==0}
	</tr><tr class = "sudoku-line">
	{/if}
{/foreach}
</tr></table>
<div class="hide">
	<table class="insert-num" id="basic-insert">
	{for $i=1 to 9}
		<td class = "sudo-numer" id="num-{$i}">{$i}</td>
		{if $i%3==0}
		</tr><tr>
		{/if}
	{/for}
	</table>
</div>
<script type="text/javascript" src="/js/sudoku.js"></script>