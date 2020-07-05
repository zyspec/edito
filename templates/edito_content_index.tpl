<{if $infos.status == 4}>
	<{include file="db:edito_content_html.tpl"}>
<{elseif $infos.status == 5}>
	<{include file="db:edito_content_php.tpl"}>
<{else}>
	<{include file="db:edito_content_item.tpl"}>
<{/if}>
