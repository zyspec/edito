<{include file="db:edito_head.tpl"}>

<div class="item">
<div class="itemHead"><{$module_name}></div>
<{if $textindex}><div class="itemText"><{$textindex}></div><{/if}>
<{if $pagenav}>
	<div style="align:left;width:160px;"><{$page}> <{$pagenav}></div><br>
<{/if}>
<table cellpadding="2" cellspacing="2" border="0">
<tr>

<{foreach item=info from=$infos}>
	<td width="<{$width}>%" align="center">
		<{if $info.logo}><{$info.logo}><{else}><{$info.subject}><{/if}>
		</a><{$info.tag}>
	</td>
<{if $info.count is div by $columns}>
	</tr>
	<tr>
<{/if}>
<{/foreach}>

</tr>
</table>
<{if $pagenav}>
	<div style="align:left;width:160px;"><{$page}> <{$pagenav}></div><br>
<{/if}>
</div>

	<{if $adminlink}><p>
		<div class="item">
		<div class="itemFoot"><{$adminlink}></div>
		</div>
	<{/if}>


<{include file="db:edito_foot.tpl"}>
