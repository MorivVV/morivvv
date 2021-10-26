{include file="sys/addCSS.tpl" css=array('gallery','masonry')}

{include file='gallery/loadImage.tpl'}

{include file='gallery/folderList.tpl'}

{include file='gallery/pagePhoto.tpl'}

<div class="wrapper tile">
	{foreach $files as $tr}
		<div class="galblock">
			<div onclick="viewPicture(this)" {if $tr.ori} class="wide"{else} class="vert"{/if}>
			<img src="{$dirfoto}{$tr.tumbs}"></div>
		</div>
	{/foreach}
</div>

{include file='gallery/pagePhoto.tpl'}

<div id="previewimage" onclick="hidePicture()" ><img src=""></div>

{include file="sys/addJS.tpl" js=array('gallery_view','gallery_masonry')}
