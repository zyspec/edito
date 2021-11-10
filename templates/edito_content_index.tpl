<{if $infos.state == 4}>
	<{include file="db:edito_content_html.tpl"}>
<{elseif $infos.state == 5}>
	<{include file="db:edito_content_php.tpl"}>
<{else}>
	<{include file="db:edito_content_item.tpl"}>
<{/if}>
