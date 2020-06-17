<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <http://www.xoops.org/>
*
* Module: edito 3.0
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com/wolfactory)
*			- DuGris (http://www.dugris.info)
*/

include_once( "admin_header.php" );
xoops_cp_header();
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
$module_id = $xoopsModule->getVar('mid');

include_once ("../include/nav.php");
include_once ("../include/tagreplace.php");



$help = "<p align='center'><strong><font size='5'>Tag List </font>
</strong></p>
<br /><strong><u>GENERAL</u>
</strong>
<p />Edito allows you to use tags to replace your xoops site constant values.<p />
<strong><u>TAGS SAMPLE</u>
</strong>
<p />

<table align='center'>
<tr>
<td>[ url ] </td><td> [url]</td>
</tr>
<tr>
<td>[ sitename ] </td><td> [sitename]</td>
</tr>
<tr>
<td>[ module ] </td><td>[module]</td>
</tr>
<tr>
<td>[ name ] </td><td>[name]</td>
</tr>
<tr>
<td>[ uname ] </td><td>[uname]</td>
</tr>
<tr>
<td>[ uid ] </td><td>[uid]</td>
</tr>
<tr>
<td>[ coding ] This is a sample [ /coding ] </td><td> [coding]This is a sample[/coding]<br /></td>
</tr>
<tr>
<td>[ meta_keywords ] </td><td>[meta_keywords]</td>
</tr>
<tr>
<td>[ meta_description ] </td><td>[meta_description]</td>
</tr>
<tr>
<td>[ slogan ] </td><td>[slogan]</td>
</tr>
<tr>
<td>[ adminmail ] </td><td>[adminmail]</td>
</tr>
<tr>
<td>[ footer ] </td><td>[footer]</td>
</tr>
</table><p />

<p />*Remove spaces in the tags to make it effectives...<p />
<p />
<strong><u>DEFAULT TAG LIST</u>
</strong>
<p />
The complete list of usable tags of the website config is as following : <p />
<table border='1'><tr>
<td>	sitename	</td>		<td>	[sitename]	</td>
<td>	slogan	</td>		<td>	[slogan]	</td>	</tr><tr border='1'>
<td>	language	</td>		<td>	[language]	</td>
<td>	startpage	</td>		<td>	[startpage]	</td>	</tr><tr>
<td>	server_TZ	</td>		<td>	[server_TZ]	</td>
<td>	default_TZ	</td>		<td>	[default_TZ]	</td>	</tr><tr>
<td>	theme_set	</td>		<td>	[theme_set]	</td>
<td>	anonymous	</td>		<td>	[anonymous]	</td>	</tr><tr>
<td>	gzip_compression	</td>		<td>	[gzip_compression]	</td>
<td>	usercookie	</td>		<td>	[usercookie]	</td>	</tr><tr>
<td>	session_expire	</td>		<td>	[session_expire]	</td>
<td>	banners	</td>		<td>	[banners]	</td>	</tr><tr>
<td>	debug_mode	</td>		<td>	[debug_mode]	</td>
<td>	my_ip	</td>		<td>	[my_ip]	</td>	</tr><tr>
<td>	use_ssl	</td>		<td>	[use_ssl]	</td>
<td>	session_name	</td>		<td>	[session_name]	</td>	</tr><tr>
<td>	minpass	</td>		<td>	[minpass]	</td>
<td>	minuname	</td>		<td>	[minuname]	</td>	</tr><tr>
<td>	new_user_notify	</td>		<td>	[new_user_notify]	</td>
<td>	new_user_notify_group	</td>		<td>	[new_user_notify_group]	</td>	</tr><tr>
<td>	activation_type	</td>		<td>	[activation_type]	</td>
<td>	activation_group	</td>		<td>	[activation_group]	</td>	</tr><tr>
<td>	uname_test_level	</td>		<td>	[uname_test_level]	</td>
<td>	avatar_allow_upload	</td>		<td>	[avatar_allow_upload]	</td>	</tr><tr>
<td>	avatar_width	</td>		<td>	[avatar_width]	</td>
<td>	avatar_height	</td>		<td>	[avatar_height]	</td>	</tr><tr>
<td>	avatar_maxsize	</td>		<td>	[avatar_maxsize]	</td>
<td>	adminmail	</td>		<td>	[adminmail]	</td>	</tr><tr>
<td>	self_delete	</td>		<td>	[self_delete]	</td>
<td>	com_mode	</td>		<td>	[com_mode]	</td>	</tr><tr>
<td>	com_order	</td>		<td>	[com_order]	</td>
<td>	bad_unames	</td>		<td>	[bad_unames]	</td>	</tr><tr>
<td>	bad_emails	</td>		<td>	[bad_emails]	</td>
<td>	maxuname	</td>		<td>	[maxuname]	</td>	</tr><tr>
<td>	bad_ips	</td>		<td>	[bad_ips]	</td>
<td>	meta_keywords	</td>		<td>	[meta_keywords]	</td>	</tr><tr>
<td>	footer	</td>		<td>	[footer]	</td>
<td>	censor_enable	</td>		<td>	[censor_enable]	</td>	</tr><tr>
<td>	censor_words	</td>		<td>	[censor_words]	</td>
<td>	censor_replace	</td>		<td>	[censor_replace]	</td>	</tr><tr>
<td>	meta_robots	</td>		<td>	[meta_robots]	</td>
<td>	enable_search	</td>		<td>	[enable_search]	</td>	</tr><tr>
<td>	keyword_min	</td>		<td>	[keyword_min]	</td>
<td>	avatar_minposts	</td>		<td>	[avatar_minposts]	</td>	</tr><tr>
<td>	enable_badips	</td>		<td>	[enable_badips]	</td>
<td>	meta_rating	</td>		<td>	[meta_rating]	</td>	</tr><tr>
<td>	meta_author	</td>		<td>	[meta_author]	</td>
<td>	meta_copyright	</td>		<td>	[meta_copyright]	</td>	</tr><tr>
<td>	meta_description	</td>		<td>	[meta_description]	</td>
<td>	allow_chgmail	</td>		<td>	[allow_chgmail]	</td>	</tr><tr>
<td>	use_mysession	</td>		<td>	[use_mysession]	</td>
<td>	reg_dispdsclmr	</td>		<td>	[reg_dispdsclmr]	</td>	</tr><tr>
<td>	reg_disclaimer	</td>		<td>	[reg_disclaimer]	</td>
<td>	allow_register	</td>		<td>	[allow_register]	</td>	</tr><tr>
<td>	theme_fromfile	</td>		<td>	[theme_fromfile]	</td>
<td>	closesite	</td>		<td>	[closesite]	</td>	</tr><tr>
<td>	closesite_okgrp	</td>		<td>	[closesite_okgrp]	</td>
<td>	closesite_text	</td>		<td>	[closesite_text]	</td>	</tr><tr>
<td>	sslpost_name	</td>		<td>	[sslpost_name]	</td>
<td>	module_cache	</td>		<td>	[module_cache]	</td>	</tr><tr>
<td>	template_set	</td>		<td>	[template_set]	</td>
<td>	mail	</td>		<td>	[mail]	</td>	</tr><tr>
<td>	smtphost	</td>		<td>	[smtphost]	</td>
<td>	smtpuser	</td>		<td>	[smtpuser]	</td>	</tr><tr>
<td>	smtppass	</td>		<td>	[smtppass]	</td>
<td>	sendmailpath	</td>		<td>	[sendmailpath]	</td>	</tr><tr>
<td>	from	</td>		<td>	[from]	</td>
<td>	fromname	</td>		<td>	[fromname]	</td>	</tr><tr>
<td>	sslloginlink	</td>		<td>	[sslloginlink]	</td>
<td>	theme_set_allowed	</td>		<td>	[theme_set_allowed]	</td>	</tr><tr>
<td>	fromuid	</td>		<td>	[fromuid]	</td>	</tr><table>";

$help = edito_tagreplace($help);

echo $help;

xoops_cp_footer();
?>