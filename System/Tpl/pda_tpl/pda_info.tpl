<?xml version="1.0" encoding="UTF-8" ?>
<root>
<count>{$count}</count>
<return>{$return}</return>
<returnflag>{$returnflag}</returnflag>
<value>
{foreach name=outer item=row from=$rows}
<row>
 {foreach key=key item=item from=$para}
【{$item}】{$self->dic_out($key,$row[$key])}
 {/foreach}
 </row>
{/foreach}
</value>
{if $session!=null}<session>{$session}</session>{/if}
{$args}
</root>