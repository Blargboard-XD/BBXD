	<table class="outline margin form form_newthread">
		<tr class="header1">
			<th colspan=2>New thread</th>
		</tr>
		<tr class="cell0">
			<td class="cell2 center" style="width: 20%;">
				Title
			</td>
			<td id="threadTitleContainer">
				{$fields.title}
			</td>
		</tr>
		<tr class="cell1">
			<td class="cell2 center" style="width: 20%;">
				Thread description
			</td>
			<td id="threadTitleContainer">
				{$fields.description}
			</td>
		</tr>
		<tr class="cell0">
			<td class="cell2 center">
				Icon
			</td>
			<td class="threadIcons">
				{$fields.icon}
			</td>
		</tr>
		<tr class="header0"><th colspan=2 style="height:5px;"></th></tr>
		<tr class="cell0 pollModeOff">
			<td class="cell2"></td>
			<td>
				{$fields.btnAddPoll}
			</td>
		</tr>
		<tr class="cell0 pollModeOn">
			<td class="cell2 center">Poll question</td>
			<td>
				{$fields.pollQuestion}
			</td>
		</tr>
		<tr class="cell1 pollModeOn">
			<td class="cell2 center">Poll options</td>
			<td>
				{$fields.pollOptions}
			</td>
		</tr>
		<tr class="cell0 pollModeOn">
			<td class="cell2 center"></td>
			<td>
				{$fields.pollMultivote}
			</td>
		</tr>
		<tr class="cell1 pollModeOn">
			<td class="cell2"></td>
			<td>
				{$fields.btnRemovePoll}
			</td>
		</tr>
		<tr class="header0"><th colspan=2 style="height:5px;"></th></tr>
		<tr class="cell0">
			<td class="cell2 center">
				Post
<table class="message margin">		<tr class="header0"><th>Smilies</th></tr>		<tr class="cell0"><td id="smiliesContainer"><div class="smilies" id="commonSet"><img src="/img/smilies/smile.png" alt=":)" title=":)" onclick="insertSmiley(' :) ');" /><img src="/img/smilies/wink.png" alt=";)" title=";)" onclick="insertSmiley(' ;) ');" /><img src="/img/smilies/biggrin.png" alt=":D" title=":D" onclick="insertSmiley(' :D ');" /><img src="/img/smilies/blank.png" alt="o_o" title="o_o" onclick="insertSmiley(' o_o ');" /><img src="/img/smilies/awsum.png" alt=":awsum:" title=":awsum:" onclick="insertSmiley(' :awsum: ');" /><img src="/img/smilies/annoyed.png" alt="-_-" title="-_-" onclick="insertSmiley(' -_- ');" /><img src="/img/smilies/bigeyes.png" alt="o_O" title="o_O" onclick="insertSmiley(' o_O ');" /><img src="/img/smilies/lol.png" alt=":LOL:" title=":LOL:" onclick="insertSmiley(' :LOL: ');" /><img src="/img/smilies/jawdrop.png" alt=":O" title=":O" onclick="insertSmiley(' :O ');" /><img src="/img/smilies/frown.png" alt=":(" title=":(" onclick="insertSmiley(' :( ');" /><img src="/img/smilies/cry.png" alt=";_;" title=";_;" onclick="insertSmiley(' ;_; ');" /><img src="/img/smilies/mad.png" alt="&gt;:" title="&gt;:" onclick="insertSmiley(' >: ');" /><img src="/img/smilies/eek.png" alt="O_O" title="O_O" onclick="insertSmiley(' O_O ');" /><img src="/img/smilies/glasses.png" alt="8-)" title="8-)" onclick="insertSmiley(' 8-) ');" /><img src="/img/smilies/cute.png" alt="^_^" title="^_^" onclick="insertSmiley(' ^_^ ');" /><img src="/img/smilies/cute2.png" alt="^^;;;" title="^^;;;" onclick="insertSmiley(' ^^;;; ');" /><img src="/img/smilies/yuck.png" alt="&gt;_&lt;" title="&gt;_&lt;" onclick="insertSmiley(' >_< ');" /><img src="/img/smilies/shiftleft.png" alt="&lt;_&lt;" title="&lt;_&lt;" onclick="insertSmiley(' <_< ');" /><img src="/img/smilies/shiftright.png" alt="&gt;_&gt;" title="&gt;_&gt;" onclick="insertSmiley(' >_> ');" /><img src="/img/smilies/dizzy.png" alt="@_@" title="@_@" onclick="insertSmiley(' @_@ ');" /><img src="/img/smilies/angel.png" alt="^~^" title="^~^" onclick="insertSmiley(' ^~^ ');" /><img src="/img/smilies/evil.png" alt="&gt;:)" title="&gt;:)" onclick="insertSmiley(' >:) ');" /><img src="/img/smilies/sick.png" alt="x_x" title="x_x" onclick="insertSmiley(' x_x ');" /><img src="/img/smilies/tongue.png" alt=":P" title=":P" onclick="insertSmiley(' :P ');" /><img src="/img/smilies/wobbly.png" alt=":S" title=":S" onclick="insertSmiley(' :S ');" /><img src="/img/smilies/vamp.png" alt=":[" title=":[" onclick="insertSmiley(' :[ ');" /><img src="/img/smilies/baby.png" alt="~:o" title="~:o" onclick="insertSmiley(' ~:o ');" /><img src="/img/smilies/yes.png" alt=":YES:" title=":YES:" onclick="insertSmiley(' :YES: ');" /><img src="/img/smilies/no.png" alt=":NO:" title=":NO:" onclick="insertSmiley(' :NO: ');" /><img src="/img/smilies/heart.png" alt="&lt;3" title="&lt;3" onclick="insertSmiley(' <3 ');" /><img src="/img/smilies/colonthree.png" alt=":3" title=":3" onclick="insertSmiley(' :3 ');" /><img src="/img/smilies/approve.png" alt=":up:" title=":up:" onclick="insertSmiley(' :up: ');" /><img src="/img/smilies/deny.png" alt=":down:" title=":down:" onclick="insertSmiley(' :down: ');" /><img src="/img/smilies/durrr.png" alt=":durr:" title=":durr:" onclick="insertSmiley(' :durr: ');" /><img src="/img/smilies/embarras.png" alt="^^;" title="^^;" onclick="insertSmiley(' ^^; ');" /><img src="/img/smilies/barf.png" alt=":barf:" title=":barf:" onclick="insertSmiley(' :barf: ');" /><img src="/img/smilies/ashamed.png" alt="._." title="._." onclick="insertSmiley(' ._. ');" /><img src="/img/smilies/umm.png" alt="'.'" title="'.'" onclick="insertSmiley(' \'.\' ');" /><img src="/img/smilies/downcast.png" alt="'_'" title="'_'" onclick="insertSmiley(' \'_\' ');" /><img src="/img/smilies/teeth.png" alt=":big:" title=":big:" onclick="insertSmiley(' :big: ');" /><img src="/img/smilies/lawl.png" alt=":lawl:" title=":lawl:" onclick="insertSmiley(' :lawl: ');" /><img src="/img/smilies/ninja.png" alt=":ninja:" title=":ninja:" onclick="insertSmiley(' :ninja: ');" /><img src="/img/smilies/pirate.png" alt=":pirate:" title=":pirate:" onclick="insertSmiley(' :pirate: ');" /><img src="/img/smilies/outrage.png" alt="D:" title="D:" onclick="insertSmiley(' D: ');" /><img src="/img/smilies/sob.png" alt=":sob:" title=":sob:" onclick="insertSmiley(' :sob: ');" /><img src="/img/smilies/xd.png" alt=":XD:" title=":XD:" onclick="insertSmiley(' :XD: ');" /><img src="/img/smilies/nyan.gif" alt=":nyan:" title=":nyan:" onclick="insertSmiley(' :nyan: ');" /><img src="/img/smilies/frown_improved.png" alt=":c" title=":c" onclick="insertSmiley(' :c ');" /><img src="/img/smilies/yum.png" alt=":yum:" title=":yum:" onclick="insertSmiley(' :yum: ');" /></div></td></tr></table>
			</td>
			<td>
				{$fields.text}
			</td>
		</tr>
		<tr class="cell2">
			<td></td>
			<td>
				{$fields.btnPost}
				{$fields.btnPreview}
				{$fields.mood}
				{$fields.nopl}
				{$fields.nosm}
				{$fields.lock}
				{$fields.stick}
			</td>
		</tr>
	</table>
