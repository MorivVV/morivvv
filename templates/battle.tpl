
{include file="sys/addCSS.tpl" css=array('snake')}
{foreach $level as $l}
    <span class="autor_theme"><a href="/game/battle-{$l.KOD_STAGE}">{$l.KOD_STAGE}</a></span>
{/foreach}
<br><hr>
<canvas id='cnv' map='{$map}'>Обновите браузер</canvas>

{include file="sys/addJS.tpl" js=array('battle')}
