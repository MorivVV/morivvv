 <div class="row">
    <div id='imagetitle-' class="col s12">
      <div class="card">
	  <div class="card-content">
          
			{if $user_id > 0}
		<span class="info">
                    <input type='text' name="picname" onChange='img_name_change(this)' id='{$img.gaid}' value='{$img.original_name}'>
                    {html_options name=folder options=$folders selected=$img.kod_folder}
		<img onclick="addGallery(this)" src="/image/system/{if $img.ga eq ''}add_plus{else}refresh{/if}.png" alt="{$img.id}" title="{if $img.ga eq ''}Добав{else}Перемест{/if}ить в галерею">
		</span>

                    <div class="info">
                        <div class="size">Размеры:{$img.width}x{$img.height}</div> 
                        <div class="autor">Загрузил:<a href="/profile/{$img.userid}">{$img.USER_NAME}</a> {$img.ADD}</div>
                    </div>
                {/if}

        </div>
        <div class="card-image">
          <img src='/image/
	{if $img.720p != ''}
		720p/{$img.720p}
	{else}
		{$img.ORIG_IMAGE}
	{/if}
	'>
          <span class="card-title">{$img.original_name}</span>
        </div>
        
        <div class="card-action">
          {if $img.720p != ''}<a target='_blank' href='/image/720p/{$img.720p}'>720p</a>{/if}	 
		{if $img.1080p != ''}<a target='_blank' href='/image/1080p/{$img.1080p}'>1080p</a>{/if}
		 <a target='_blank' href='/image/{$img.ORIG_IMAGE}'>Оригинал фото</a>
		 <form method="post" action="/gallery/brick">
                     <input name="imgname" hidden="" value="{$img.ORIG_IMAGE}">
                     <input type="submit" value="Удалить фото">
                 </form>
        </div>
		<div class="card-action">
		{foreach from=$folders item=fd key=fid}
                    {$check = $fd|replace:' + ':'#'}
                    {if $fd != $check}
                            <a href="/gallery/brick-{$fid}"> {$check} </a>
                    {/if}
            {/foreach}
			</div>
      </div>
    </div>
  </div>
 

<script>
	var alpic = $('div[onclick="viewPicture(this)"] img');
	var tumbs = "{$tumbs}";
	var n = 0;
	$("div .imginfo").append("<div id='allpic'></div>");
	for (var i=0;i<alpic.length;i++){
		var s = alpic[i].src;
		if (s.indexOf(tumbs)>0) n = i;
	}
	for (var i=n-2;i<=n+2;i++){
		if (i >=0 && i<alpic.length) {
			var newtumb = alpic[i].src;
			$("#allpic").append("<div onclick='viewPicture(this)' style='display: inline;'><img height='30px' src='"+newtumb+"'></div>");
		}
	}
</script>