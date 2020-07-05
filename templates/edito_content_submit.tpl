<{include file="db:edito_head.tpl"}>

<div class="item">
    <div class="itemHead"><{$submit}></div>
	<{if $submitext}><div class="itemText"><{$submitext}></div><{/if}> 
<form name="edito" method="post">
	<table>
		<tr>
		    <td><{$subject}> :</td>
		    <td><input type="text" size="60" name="subject"></td>
	    </tr>
    <{if $text}>
		<tr>
            <td><{$text}> :</td>
            <td><textarea cols="45" rows="6" name="description" type="text" wrap="virtual"></textarea></td>
	   </tr>
    <{/if}>

    <{if $media}>
		<tr>
            <td><{$media}> :</td>
            <td><input type="text" size="60" name="media"></td>
        </tr>

    <{/if}>
        <tr>
            <td colspan="2" class="center"><button type="submit" /><{$submit}></button><{$security_token}><td>
        </tr>
	</table>
</form>

	<{if $infos.displaylogo && $infos.logo}><br>
			<{$infos.logo}><p></p>
	<{/if}>

	<div class="itemText">
		<{$infos.subject}>
		<{$infos.media}><br>
		<{$infos.text}><p></p>
	</div>
</div>

<{if $adminlinks}><p />
	<div class="item">
		<div class="itemFoot"><{$adminlinks}></div>
	</div>
<{/if}>

<{include file="db:edito_foot.tpl"}>
