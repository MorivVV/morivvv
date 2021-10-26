<div class="topic-page">
    Всего {$full}. Отображаются с {$current+1} по {if $current+$onPage>$full}{$full}{else}{$current+$onPage}{/if}:
    {for $i=0 to $full step $onPage}
        <span class="page">
            {if $i eq $current}<span> {$i/$onPage+1} </span>
            {else} <a href="/{if $topic eq 0}usermessage{else}topic{/if}/{$topic}-{$i}-{$user}">{$i/$onPage+1}</a> {/if} 
        </span>
    {/for}
</div>