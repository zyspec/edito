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
				<{if $info.block_text}>
					<table align="right" style="padding:3px; margin:6px; border:2px outset; width:25%;">
					<tr><th>
						<{$info.alt_subject}>
						</th></tr>
					<tr><td>
						<div style="font-style:italic;">
						<{$info.block_text}>
						</div>
					</td><tr>
					</table>
				<{/if}>
                           <p class="itemText"><{$info.logo}><{$info.body_text}><br><br>
                                                  <div style="text-align:right;"><{$info.popup}></div></p>
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

