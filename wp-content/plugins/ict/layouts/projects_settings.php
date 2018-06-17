<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/1/2018
 * Time: 9:49 AM
 */

?>
<div class="wrap">
	<h1>Project Settings Page</h1>
	<?php if(isset($_GET['message']) && $_GET['message'] == '1'):?>
		<div id="message" class="updated fade">
			<p><strong>Settings Saved</strong></p>
		</div>
	<?php endif;?>

	<?php WfHtml::wf_beginForm('post',WfHtml::wf_getPageUrl('xhuma-projects-main-page'),'xhuma-projects-settings');?>

	<table class="form-table">
		<tbody>
        <tr>
            <th><label>Projects ShortCode</label></th>
            <td><span>[ShortCode Id]</span></td>
        </tr>
        <tr>
            <th><label>Projects Attributes</label></th>
            <td><span>[ShortCode Id]</span></td>
        </tr>
		<tr>
			<th><label>Api Url</label></th>
			<td><?php echo WfHtml::wf_text_input('api_url',  esc_html($options['api_url']),array(
					'style'=>'width:60%;'
				));?></td>
		</tr>
		</tbody>

	</table>
	<?php echo WfHtml::wf_submitButton();?>

	<?php WfHtml::wf_endForm();?>
</div>