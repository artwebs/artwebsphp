{foreach name=outer item=item from=$para}
<row>
<NAME>{$item.name}</NAME>
<CNAME>{$item.cname}</CNAME>
<VALUE>{$item.value}</VALUE>
<CONMETHOD>{$item.conmethod}</CONMETHOD>
<DISPALY>{$item.display}</DISPALY>
<MATCHE>{$item.match}</MATCHE>
<CONURL>{$item.conurl|regex_replace:"/\&/":"#and"}</CONURL>

{if $item.readonly!=false}<READONLY>{$item.readonly}</READONLY>{/if}
{if $item.dicvalue!=false}<DICVALUE>{$item.dicvalue}</DICVALUE>{/if}
{if $item.nexturl!=false}<NEXTURL>{$item.nexturl|regex_replace:"/\&/":"#and"}</NEXTURL>{/if}
{if $item.checkboxurl!=false}<CHECKBOXURL>{$item.checkboxurl|regex_replace:"/\&/":"#and"}</CHECKBOXURL>{/if}
{if $item.getvalue!=false}<GETVALUE>{$item.getvalue}</GETVALUE>{/if}
{if $item.maxcount!=false}<MAXCOUNT>{$item.maxcount}</MAXCOUNT>{/if}
 </row>
{/foreach}
