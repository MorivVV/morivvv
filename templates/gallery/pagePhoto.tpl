<div id="galleryPage" class="gal_nav gal_next">
{for $var=0 to $cnt step $step}
	{if $lim == $var}
		<b> {$var} </b>
	{else}
            <a href="/gallery/{$tpl}-{$folder}-{$var}-{$step}-{$hdef}" onclick="event.preventDefault();" :click="lim+=+step"> {$var} </a>
	{/if}
{/for}
</div>