<{include file="db:edito_head.tpl"}>

<div class="item">
<div class="itemHead"><{$module_name}></div>
<{if $textindex}><div class="itemText"><{$textindex}></div><{/if}>

<{if $pagenav}>
	<div style="align:left;width:160px;"><{$page}> <{$pagenav}></div><br>
<{/if}>

<table class="outer">
  <tr class="head">
	<th width="10" align="center"><{$lang_num}></th>
	<th align="center"><{$lang_subject}></th>
	<th align="center"><{$lang_block_texte}></th>
	<th align="center"><{$lang_info}></th>
 </tr>

<{foreach item=info from=$infos}>
  <tr class="<{cycle values="even,odd"}>">
	<td class="head" style="text-align:center;"><{$info.count}></td>
	<td style="text-align:center;"><{if $info.logo}><{$info.logo}><{else}><{$info.subject}><{/if}></td>
	<{if $info.block_text || $info.popup}><td><{$info.block_text}><br><br>
                                                  <div style="text-align:right;"><{$info.popup}><{$info.readmore}></div></td>
	<td style="text-align:right; width:160px;"><{else}>
        <td colspan="2" style="text-align:right;"><{/if}><{$info.info}> [<{$info.counter}>]</td>
  </tr>
<{/foreach}>
</table>

<{if $pagenav}>
	<div style="align:left;width:160px;"><{$page}> <{$pagenav}></div><br>
<{/if}>
</div>
<br>
	<{if $adminlink}><p>
		<div class="item">
		<div class="itemFoot"><{$adminlink}></div>
		</div>
	<{/if}>

<{include file="db:edito_foot.tpl"}>
