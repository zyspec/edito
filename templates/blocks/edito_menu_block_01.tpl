<{if $block.format == "pic"}>
	<{include file="db:edito_block_image.tpl"}>
<{elseif $block.format == "menu"}>
	<{include file="db:edito_block_menu.tpl"}>
<{elseif $block.format == "ext"}>
	<{include file="db:edito_block_ext.tpl"}>
<{else}>
	<{include file="db:edito_block_list.tpl"}>
<{/if}>
