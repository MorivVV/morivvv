{include file="sys/addCSS.tpl" css=array('profile','trep','masonry')}

<div id='user-block' class="block">
    <div class="photo">
        <img id="user_pic" src="/image/tumbs/{$img}" alt="{$img}">
    </div>	
    <div class="opis">{literal}
        <div v-for='(func, nam) in out' class="line-opis">
            <div class="param">{{nam}}</div>
            <div class="func">{{nam == 'Часовой пояс' ? func : ''}}
                <select v-if="nam == 'Часовой пояс'" v-model="out['Часовой пояс']" :name="nam"> 
                    <option v-for="i in 24" :label="'UTC'+(i-10)" :value="(i<10 ? '-' : '+')+(i < 20 ? '0' : '') + Math.abs(i-10) +':00'" >UTC {{ i-10 }}</option> 
                </select>
                <input v-else-if="nam == 'Режим отладки'" v-model="out['Режим отладки']" type='checkbox' onclick="ScanerChange(this)" :name="nam" :value="func=='1'" >
                <input v-else type="text" :name="nam" :disabled="nam=='ID'" :value="func">
            </div>
        </div>{/literal}
        {if $user_autorization}<input type="submit" onclick="changeProfile(this.parentNode)" value="Сохранить изменения" /> {/if}
        <span id="checkok"></span>
    </div>
	
    <form enctype="multipart/form-data" action="/index.php?url=upload_image_update" method="POST">
        <div class="upload">
            <input type="file" name ="imgupload"><br>
            <input type="checkbox" name ="userpic" value="2">Использовать для профиля<br>
            <input type="submit" value="загрузить фото" />
        </div>
    </form>
</div> 
 <div id="previewimage" onclick="hidePicture()" ><img src=""></div>
{if $user_autorization}
<div id="newMessage">
<form action="/sendmessage" method="post">
    <input type="hidden" value="{$ID}" name="user_to">
    <input type="hidden" value="{$DT}" name="timenow">
    <input type="hidden" value="" id="m_attach" name="messageattach">
    <table>
        <tr>
            <td></td>
            <td><b>Отправить сообщение этому пользователю</b></td>
        </tr>
        <tr>
            <td><b>Тема</b></td>
            <td><input type="text" name="theme"></td>
        </tr>
        <tr>
            <td><b>Cообщение </b>
            </td>
            <td>{$smiles}<br>
            <textarea class="textadd" required name="POST" id="posttext" cols="80" rows="4"></textarea></td>
        </tr>	
        <tr>
            <td></td>
            <td><input type="submit"></td>
        </tr>
    </table>
</form>
</div>
{/if}
 {include file="sys/addJS.tpl" js=array('smile','gallery_masonry','vue/smileTemplate')}
 {assign var="aname" value=""}
{foreach $date_sms as $dsms}
    <div class="window-date">{$dsms}</div>
    {foreach $trepdata as $sms}
    {if $dsms == $sms.date}
    <div class="window-sms">
        <div class="window-photo">{if $aname != $sms.autor}<a href="/profile/{$sms.autor}"><img src="/img.php?tumbs={$sms.avatar}"></a>{/if}</div>
        <div class="window-msg">
            {if $aname != $sms.autor}
            <div class="window-head">
                <span class="window-autor"><a href="/profile/{$sms.autor}">{$sms.autor}</a></span>
            </div>
            {/if}
            <span class="window-time">{$sms.time}</span>
            <div class="window-text">{$sms.text}</div>
        </div>
    </div>
    {assign var="aname" value=$sms.autor}
    {/if}
    {/foreach}
{/foreach}
{if $prev<0}
    <div style="float:left"><a href='/profile/{$ID}-{$next}'><<Назад</a></div>
{else}
    <div style="float:left"><a href='/profile/{$ID}-{$next}'><<Назад</a></div>
    <div align="right"><a href='/profile/{$ID}-{$prev}'> >>Вперед </a> </div>
{/if}
<script>
    let ublock = new Vue({
        el: '#user-block',
        data() {
            return { 
            out: {$jout},
            user_id:{$ID}
            }
        }
    });
function changeProfile(opis){
	$('#checkok').load('/changeUser$', 
        { 'FAMILY': $('input[name="Фамилия"]')[0].value
        , 'NAME': $('input[name="Имя"]')[0].value
        , 'ip': $('input[name="ip"]')[0].value
        , 'Браузер': $('input[name="Браузер"]')[0].value
        , 'SURNAME': $('input[name="Отчество"]')[0].value
        , 'timezone': $('select[name="Часовой пояс"]')[0].value
        , 'email': $('input[name="Почтовый ящик"]')[0].value
        , 'debug': $('input[name="Режим отладки"]')[0].value
        , 'ID': $('input[name="ID"]')[0].value});
}
$('.spoiler_head').click(function(){
	var el = this.nextElementSibling;
	if ($(el).css("display") == "none"){
		$(el).show('slow', function() {});
		$(this).removeClass('spoiler_head_close').addClass('spoiler_head_open');
		$(this).css("border-radius", "5px 5px 0 0");
		}
	else {
		$(el).hide('slow', function() {});
		$(this).removeClass('spoiler_head_open').addClass('spoiler_head_close');
		$(this).css("border-radius", "5px");
		}
});
</script>