<{include file="db:edito_head.tpl"}>

<{if $navlink}><div style="width:160px;"><{$navlink}></div><{/if}>

<div class="item">
	<{if $infos.displaytitle}>
	  <div class="itemHead"><{$infos.meta_title}></div>
		<{if $infos.infos OR $infos.downloadable}>
			<div class="itemInfo"><{$infos.infos}><{$infos.downloadable}></div>
		<{/if}>
	<{/if}>

<{if $breaknav}><div class="itemPermaLink" style="text-align:right;width:160px;"><{$breaknav}></div><{/if}>

<{if $infos.block_text}>
	<table align="right" style="padding:3px; margin:6px; border:2px outset; width:40%;">
		<tr><th>
			<{$infos.title}>
		</th></tr>
		<tr><td>
			<{$infos.block_text}>
		</td><tr>
	</table>
<{/if}>

<{if $navlink AND $navlink_type == 'bloc'}>
	<table align="right" style="padding:3px; margin:6px; border:2px outset; width:40%;">
		<tr><th>
			<a href="./"><{$index}></a>
		</th></tr>
		<tr><td><ul>
	<{foreach item=listing from=$liste}>
		<li><{$listing.link}></li>
	<{/foreach}>
		</ul>
		<{$readmore}></td></tr>
	</table>
<{/if}>

	<{if $infos.displaylogo AND $infos.logo}><br>
			<{$infos.logo}><p>
	<{/if}>

<div class="itemText">
	<{$infos.media}><br>
	<{$infos.body_text}><p>
	<{if $breaknav}><div class="itemPermaLink" style="text-align:right;width:160px;"><{$breaknav}></div><{/if}>
</div>

<{if $navlink AND $navlink_type == 'path'}><hr>
	<div style="text-align:center;"><a href="./"><{$index}></a>
	<{foreach item=listing from=$liste}>
	<{if $listing.cols}>
	<br><{else}>&nbsp;|&nbsp;
	<{/if}>
	<{$listing.link}>
	<{/foreach}><{$readmore}><br></div>
<{/if}>

<p>
	<div class="itemFoot">
		<{$infos.adminlink}>
	</div>

</div>

<{if $infos.adminlinks}><p>
	<div class="item">
		<div class="itemFoot"><{$infos.adminlinks}></div>
	</div>
<{/if}>

<{if $navlink AND $navlink_type == 'list'}>
<p>
<div class="item">
	<div class="itemHead"><{$list}></div>
<table>
<tr><td>
		<ul>
		<{foreach item=liste from=$liste}>
	<{if $liste.cols}>
		</ul>
		</td>
		<td>
		<ul>
	<{/if}>
		<li><{$liste.link}><{$liste.tag}></li>
		<{/foreach}>
		</ul>
<{$readmore}>
</td></tr>
</table>
</div>
<{/if}>

<{include file="db:edito_foot.tpl"}>

<{if $infos.cancomment}>
	<table border="0" width="100%" cellspacing="1" cellpadding="0" align="center" >
   	<tr>
	    <td colspan="3" align ="left">
      	<div style="text-align: center; padding: 3px; margin:3px;"> <{$commentsnav}> <{$lang_notice}></div>
      	<div style="margin:3px; padding: 3px;">
	        <!-- start comments loop -->
        	<{if $comment_mode == "flat"}> <{include file="db:system_comments_flat.tpl"}>
        	<{elseif $comment_mode == "thread"}> <{include file="db:system_comments_thread.tpl"}>
        	<{elseif $comment_mode == "nest"}> <{include file="db:system_comments_nest.tpl"}>
        	<{/if}>
        	<!-- end comments loop -->
      	</div>
    	</td>
  	</tr>
	</table>
<{/if}>
