<div id="newMessage">
    <form action="/sendpost" method="post">
        <b id="qq">Новая тема</b><input {if $topic eq 0}required{/if} type="text" name="theme">
        <input type="checkbox" name="private" onclick="ScanerChange(this)" value="0"><label for="private">Личная тема (видно только создателю)</label>
        {$smiles}		  
        <textarea class="textadd" required name="POST" id="posttext" cols="80" rows="3"></textarea>

        <input hidden type="text" name="topic" value="{$topic}">
        <input type="hidden" name="qpost" id="qanswer" value="" >
        <p><input value="{if $topic eq 0}Создать тему{else}Отправить{/if}" type="submit"> <input type="reset"></p>
    </form>
</div>