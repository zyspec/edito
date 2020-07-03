<{if $block.format == "pic"}>
	<{include file="db:edito_block_image.html"}>
<{elseif $block.format == "menu"}>
	<{include file="db:edito_block_menu.html"}>
<{elseif $block.format == "ext"}>
	<{include file="db:edito_block_ext.html"}>
<{else}>
	<{include file="db:edito_block_list.html"}>
<{/if}>
