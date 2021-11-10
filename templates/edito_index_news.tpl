<{include file="db:edito_head.tpl"}>

<{if $textindex}><div class="itemText"><{$textindex}></div><{/if}>

<{if $pagenav}>
	<div style="align:left;width:160px;"><{$page}> <{$pagenav}></div><br>
<{/if}>


<table cellpadding="0" cellspacing="0" class="item">
    <tr>
        <td>
<{foreach item=info from=$infos}>
        <table cellpadding="0" cellspacing="0" width="98%">
            <tbody>
                <tr>
                    <td class="itemHead">
                        <span class="itemTitle"><a href='./'><{$module_name}></a>&nbsp;:&nbsp;<{$info.subject}></span>
                    </td>
                </tr>
                <tr>
                    <td class="itemInfo">
                        <span class="itemPostDate"><{$info.info}></span> [<span class="itemStats"><{$info.counter}> <{$lang_read}></span>]
                    </td>
                </tr>
                <tr>
                    <td><div class="itemBody">
                           <p class="itemText"><{$info.logo}><{$info.block_text}><br><br></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="itemFoot">
                        <span class="itemPermaLink"><{$info.readmore}><{$info.comment}></span>
				<span class="itemAdminLink"><{$info.adminlinks}></span>
                    </td>
                </tr>
             </tbody>
         </table>
<{/foreach}>
      </td>
  </tr>
</table>


<{if $pagenav}>
	<div style="align:left;width:160px;"><{$page}> <{$pagenav}></div><br>
<{/if}>

	<{if $adminlink}><p>
		<div class="item">
		<div class="itemFoot"><{$adminlink}></div>
		</div>
	<{/if}>

<{include file="db:edito_foot.tpl"}>

