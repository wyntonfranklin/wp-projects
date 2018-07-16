<?php
PJHtml::wf_registerStyle('calender-picker-style', plugins_url( '/public/css/jquery.datetimepicker.css', __DIR__ ),
    '1.1');
PJHtml::wf_registerStyle('editor-style', plugins_url( '/public/css/trumbowyg.min.css', __DIR__ ),
    '1.1');
PJHtml::wf_registerScript('calendar-picker',
    plugins_url( '/public/js/jquery.datetimepicker.full.js', __DIR__ ),'1.0');
PJHtml::wf_registerScript('editor-trumb',
    plugins_url( '/public/js/trumbowyg.min.js', __DIR__ ),'1.0');
?>
<div class="wrap">
	<h1>Create New Project</h1><br>
    <a class="page-title-action" href="<?php echo PJHtml::getPageUrl('ict-projects-main-page');?>">Back To Projects</a>
    <br><br>

	<?php PJHtml::wf_beginForm('post',PJHtml::wf_getPageUrl('ict-new-project-page'),'xhuma-projects-settings');?>

	<table class="form-table">
		<tbody>
		<tr>
			<th><label>Project Name</label></th>
			<td><?php echo PJHtml::wf_text_input('project_name',  esc_html($options['api_url']),array(
					'style'=>'width:60%;',
				));?></td>
		</tr>

		<tr>
			<th><label>Project Description</label></th>
            <td>
                <div style="width:60%;">
                    <?php echo PJHtml::wf_textArea('project_description', esc_html($project['project_description']),array(
                        'id' => 'editor',
                        'rows'=>'9',
                        'style'=>'width:60%;',
                    ));?>
                </div>
            </td>
		</tr>

		<tr>
			<th><label>Type of Project</label></th>
            <?php
                $pModel = new PJModel('wp_ict_project_types');
                $types = $pModel->findAll();
                $typesData = array();
                foreach($types as $type){
                    $typesData[$type['project_type']] = $type['project_type'];
                }
            ?>
			<td><?php echo PJHtml::wf_dropDownBox('project_type',  "",$typesData,array(
					'style'=>'width:60%;'
				));?></td>
		</tr>

		<tr>
			<th><label>Client</label></th>
			<td><?php echo PJHtml::wf_text_input('project_client',  "",array(
					'style'=>'width:60%;'
				));?></td>
		</tr>

		<tr>
			<th><label>Start Date</label></th>
			<td><?php echo PJHtml::wf_text_input('start_date',  "",array(
					'style'=>'width:60%;',
					'id' => 'start_date'
				));?></td>
		</tr>

		<tr>
			<th><label>End Date</label></th>
			<td><?php echo PJHtml::wf_text_input('end_date',  "",array(
					'style'=>'width:60%;',
					'id' => 'end_date'
				));?></td>
		</tr>

        <tr>
            <th><label>Ongoing</label></th>
            <td><?php echo PJHtml::wf_checkBox('current',  "",array(
				));?></td>
        </tr>

		<tr>
			<th><label>Reference</label></th>
			<td><?php echo PJHtml::wf_text_input('ref_url',  "",array(
					'style'=>'width:60%;'
				));?></td>
		</tr>

        <tr>
            <th><label>Published</label></th>
            <td><?php echo PJHtml::wf_checkBox('published',  "",array(
                ));?></td>
        </tr>


		</tbody>

	</table>
	<?php echo PJHtml::wf_submitButton('ict_projects_submit');?>

	<?php PJHtml::wf_endForm();?>
</div>

<script>
	jQuery(function($){
        $('#start_date').datetimepicker({
            timepicker:false,
            format:'Y-m-d',
            scrollMonth : false,
            scrollInput : false,
        });

        $('#end_date').datetimepicker({
            timepicker:false,
            format:'Y-m-d',
            scrollMonth : false,
            scrollInput : false,
        });

        $('#editor').trumbowyg({
            svgPath: false,
            btns: [
                ['bold', 'italic'],
                ['link'],
            ]
        });

	});
</script>