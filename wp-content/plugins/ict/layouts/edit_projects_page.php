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
    <h1>Edit Project</h1><br>
    <a class="page-title-action" href="<?php echo PJHtml::getPageUrl('ict-projects-main-page');?>">Back To Projects</a>
    <a class="page-title-action" href="<?php echo PJHtml::adminUrl('ict-project-team-members',[
        'id'=>$project['project_id']
    ])?>">View Team</a>
    <br><br>
    <?php if(isset($_GET['message']) && $_GET['message'] == '1'):?>
        <div id="message" class="updated fade">
            <p><strong>Settings Saved</strong></p>
        </div>
    <?php endif;?>

    <?php PJHtml::wf_beginForm('post',PJHtml::adminUrl('ict-edit-project-page',[
        'id'=>$project['project_id']
    ]),'ict-projects-settings');?>

    <table class="form-table">
        <tbody>
        <tr>
            <th><label>Project Name</label></th>
            <td><?php echo PJHtml::wf_text_input('project_name',  esc_html($project['project_name']),array(
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
            <td><?php echo PJHtml::wf_dropDownBox('project_type',  esc_html($project['type']), $typesData,array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Client</label></th>
            <td><?php echo PJHtml::wf_text_input('project_client',  esc_html($project['client']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Start Date</label></th>
            <td><?php echo PJHtml::wf_text_input('start_date',  esc_html($project['start_date']),array(
                    'style'=>'width:60%;',
                    'id' => 'start_date'
                ));?></td>
        </tr>

        <tr>
            <th><label>End Date</label></th>
            <td><?php echo PJHtml::wf_text_input('end_date',  esc_html($project['end_date']),array(
                    'style'=>'width:60%;',
                    'id' => 'end_date'
                ));?></td>
        </tr>

        <tr>
            <th><label>Reference</label></th>
            <td><?php echo PJHtml::wf_text_input('ref_url',  esc_html($project['ref_url']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Published</label></th>
            <td><?php echo PJHtml::wf_checkBox('published',  esc_html($project['published']),array(
                ));?></td>
        </tr>


        </tbody>

    </table>
    <?php echo PJHtml::wf_submitButton('ict_projects_update_submit','Update Project');?>

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