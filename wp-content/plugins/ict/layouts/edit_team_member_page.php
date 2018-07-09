<div class="wrap">
    <h1>Edit Team Member</h1><br>
        <a class="page-title-action" href="<?php echo PJHtml::getPageUrl('ict-projects-teams-page');?>">Back To Teams</a>
        <a class="page-title-action" href="<?php echo PJHtml::adminUrl('ict-project-team-members',[
            'id'=>$team['project_id']
        ])?>">View Project Team</a>
    <br><br>
    <?php if(isset($_GET['message']) && $_GET['message'] == '1'):?>
        <div id="message" class="updated fade">
            <p><strong>Settings Saved</strong></p>
        </div>
    <?php endif;?>

    <?php PJHtml::wf_beginForm('post',PJHtml::adminUrl('ict-edit-team-member-page',[
        'id'=>$team['team_id']
    ]),'xhuma-projects-settings');?>

    <table class="form-table">
        <tbody>
        <tr>
            <th><label>Title</label></th>
            <td><?php echo PJHtml::wf_text_input('title',  stripslashes($team['title']),array(
                    'style'=>'width:60%;',
                ));?></td>
        </tr>

        <tr>
            <th><label>Team Member Name</label></th>
            <td><?php echo PJHtml::wf_text_input('name',  stripslashes($team['team_name']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Project</label></th>
            <?php
            $projects = new PJModel('wp_ict_projects');
            $projects = $projects->findAll();
            $data = null;
            foreach($projects as $project){
                $data[$project["project_id"]] = stripslashes($project["project_name"]);
            }
            ?>
            <td><?php echo PJHtml::wf_dropDownBox('project',  esc_html($team['project_id']), $data, array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Description</label></th>
            <td><?php echo PJHtml::wf_textArea('description',  stripslashes($team['description']),array(
                    'style'=>'width:60%;' ,'rows'=>'15'
                ));?></td>
        </tr>


        <tr>
            <th><label>Position</label></th>
            <td><?php echo PJHtml::wf_text_input('position',  stripslashes($team['position']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>


        <tr>
            <th><label>Contact</label></th>
            <td><?php echo PJHtml::wf_text_input('contact',  esc_html($team['contact']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>

        <tr>
            <th><label>Email</label></th>
            <td><?php echo PJHtml::wf_text_input('email',  esc_html($team['email']),array(
                    'style'=>'width:60%;'
                ));?></td>
        </tr>



        </tbody>

    </table>
    <?php echo PJHtml::wf_submitButton('ict_teams_update_submit');?>

    <?php PJHtml::wf_endForm();?>
</div>
