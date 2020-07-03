<{if $infos.status == 4}>
	<{include file="db:edito_content_html.html"}>
<{elseif $infos.status == 5}>
	<{include file="db:edito_content_php.html"}>
<{else}>
	<{include file="db:edito_content_item.html"}>
<{/if}>
