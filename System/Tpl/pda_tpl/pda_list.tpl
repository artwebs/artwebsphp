<?xml version="1.0" encoding="UTF-8" ?>
<root>
<count>{$count}</count>
<return>{$return}</return>
<returnflag>{$returnflag}</returnflag>
<value>
{foreach key=outer item=row from=$rows}
<row>
 {foreach key=key item=item from=$row}
 <{$key}>{$item}</{$key}>
 {/foreach}
 </row>
{/foreach}
</value>
</root>