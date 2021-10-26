<link rel='stylesheet' type='text/css' media="screen" href='/css/phone.css' />
<form enctype="multipart/form-data" action="/uploadimageupdate" method="POST">
<div id="phone" class="block">
<div class="photo"><a href="/img.php?img={$img}"><img id="user_pic" src="/img.php?img={$img}&width=400" alt="{$img}"></a></div>
{literal}
<div class="opis">
    <template v-for="(p, k) in params">
	<div class="param">{{k}}</div>
	<div class="func"> {{p}}</div>
    </template>
</div>
    {/literal}
<div class="upload">
<input type="file" name ="imgupload"><br>
<input type="hidden" name ="id" value="{$ph_id}">
<input type="submit" value="загрузить фото" />
</div>
</div></form>
<script>
    let phone = new Vue({
        el: '#phone',
        data() {
            return { 
            params: {$jout}
            }
        }
    });
 </script>
 