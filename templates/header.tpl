{strip}
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta charset="utf-8">
<link rel="icon" type="image/png" href="/image/system/ico.png" />
{include file="sys/addCSS.tpl" css=array('materialize','pages','bg_color')}

<title>{$site_name}</title>
<audio id="player" src="/audio/z_uk-aska-z_uk.mp3"></audio> 
{include file="sys/addJS.tpl" js=array('jquery-3.4.1', 'materialize','vue','topnav','ajax','private_msg','vue/headerTemplate')}
<script>
      tinymce.init({
        selector: 'textarea'
      });
    </script>
<script>
function dragOB(d) {
	$(d).css("top", "0px").css("left", "270px");
}
</script>
</head>

<body>   
<div id="top_list"></div>
<div class="blank">
<div id="site_head"><div class="site_rem">{$site_rem}</div>
{if $user_autorization}
<div id="welcomeuser" style="top:0; left:270;" >
    <a><img src="/img.php?tumbs={$profile_image}"></a>
<b>Вы вошли как <br>
<a class="name_user" href="/profile/{$user}">{$user} </a> <br>
Ваш ip: {$addr}</b><br>
<form action="/logout" method="post"><input type="submit" value="Выход" ></form>

<i onclick="openMessage()">Личные сообщения: <b id="blink">{$countmessage}</b></i>
<div class="private_message">
<div id="user_message" >
{assign var=usr value=""}
{assign var=next value=""}
{foreach $pr_msg as $msg}
    {if $usr neq $msg.user_name}
        {if $next eq "next"}{assign var=next value=""}{else}{assign var=next value="next"}{/if}
    {/if}
    <div class="private_post {$next}" >
        {if $usr neq $msg.user_name}
            <a class="author_post offline" href="/profile/{$msg.user_name}">{$msg.user_name}</a>
        {/if}
        <span class="time_post">{$msg.times}</span>
        <span title="{$msg.user_name}" class="text_post">{$msg.message}</span>    
    </div>
    {assign var=usr value=$msg.user_name}    
{/foreach}
</div>
<input id="message" type="text" value="" placeholder = "Ответить"/>
</div>

<div class="toggle-btn" onclick="openMenu()">
	<span></span>
	<span></span>
	<span></span>
</div>
        
</div>
{else }
<form action="/login" method="post">

<div class="user_enter">
	<div class="login">Логин:<input required type="text" name="login"></div>
	<div class="password">пароль:<input required type="password" name="password"></div>
	<div class="login"><input type="submit" value="Вход"><input type="button" value="Регистрация" onClick='location.href="/register"'></div>
</div>	
</form>
{/if}</div>

<div id="mainSidebar"></div>

<div class="error_log">{$error_log}</div>
<script>
var nav = new Vue({
  el: '#mainSidebar',
  data: function data() {
    return {
      url_list: {$url_list}
    };
  },
  template: mainSidebar
});
</script>
    
