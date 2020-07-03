
	<{counter start=0 print=false}> 

<table class="outer">
	<tr class="head">
		<th><{$block.lang_num}></th>
		<th><{$block.lang_illu}></th>
		<th><{$block.lang_subject}></th>
		<th><{$block.lang_read}></th>
		<th><{$block.lang_summary}></th>
		<th><{$block.lang_info}></th>
	</tr>

<{foreach item=data from=$block.content}>
	<tr class="<{cycle values="even,odd"}>">
		<td style="text-align:center;"><{counter}></td>
		<td><{$data.image_link}></td>
		<td><{$data.link}></td>
		<td style="text-align:center; width:40px;"><{$data.read}></td>
		<td><{$data.summary}></td>
		<td style="text-align:right; width:160px;"><{$data.infos}></td>
	</tr>
<{/foreach}>
</table>

	<{$block.readmore}>
