<link rel='stylesheet' type='text/css' media="screen" href='/css/register.css' />
<form onSubmit="return check()" action="/addUser" method="post">
<div class="register"><h1>Регистрация</h1>
<div id="check"></div>
{foreach $datareg as $tr}
	<div class="info"><span>{$tr.rem}</span>
		<input required type="{$tr.type}" id="{$tr.name}" name="{$tr.name}">
	</div>
{/foreach}
</div>
</form>
<script type="text/javascript">
	$('#login').change(function(){
		$('#check').load("/ajax/chekuser.php?nick_name=" + this.value);
	});
	function check()	{
		var input1 = document.getElementById('password');
		var input2 = document.getElementById('password2');
		if (input1.value != input2.value)  	{
			alert( 'пароли не совпадают' );
			return false;
		}
		else	{	
		return true;
		}
	}
</script>