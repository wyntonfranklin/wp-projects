<div class="wrap">
    <h1>Create Team Member</h1><br>
    <a class="page-title-action" href="<?php echo WfHtml::getPageUrl('ict-projects-teams-page');?>">Back To Teams</a>
    <br><br>
    <?php if(isset($_GET['message']) && $_GET['message'] == '1'):?>
        <div id="message" class="updated fade">
            <p><strong>Settings Saved</strong></p>
        </div>
    <?php endif;?>

    <?php WfHtml::wf_beginForm('post',WfHtml::wf_getPageUrl('ict-new-team-member-page'),'xhuma-projects-settings');?>

    <table class="form-table">
        <tbody>
        <tr>
            <th><label>Title</label></th>
            <td><?php echo WfHtml::wf_text_input('title',  '',array(
                    'style'=>'width:60%;',
                ));?></td>
        </tr>

        <tr>
            <th><label>Team Member Name</label></th>
            <td><?php echo WfHtml::wf_text_input('name',  esc_html($options['api_url']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Project</label></th>
            <?php
                $projects = new WfModel('wp_ict_projects');
                $projects = $projects->findAll();
                $data = null;
                foreach($projects as $project){
                    $data[$project["project_id"]] = $project["project_name"];
                }
            ?>
            <td><?php echo WfHtml::wf_dropDownBox('project',  esc_html($options['api_url']), $data, array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Description</label></th>
            <td><?php echo WfHtml::wf_textArea('description',  esc_html($options['api_url']),array(
                    'style'=>'width:60%;','rows'=>'15'
                ));?></td>
        </tr>


        <tr>
            <th><label>Position</label></th>
            <td><?php echo WfHtml::wf_text_input('position',  esc_html($options['api_url']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>


        <tr>
            <th><label>Contact</label></th>
            <td><?php echo WfHtml::wf_text_input('contact',  esc_html($options['api_url']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Email</label></th>
            <td><?php echo WfHtml::wf_text_input('email',  esc_html($options['api_url']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>



        </tbody>

    </table>
    <?php echo WfHtml::wf_submitButton('ict_teams_submit');?>

    <?php WfHtml::wf_endForm();?>
</div>
