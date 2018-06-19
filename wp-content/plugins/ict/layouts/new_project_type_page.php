<?php
/**
 * Created by PhpStorm.
 * User: shady
 * Date: 6/19/18
 * Time: 5:23 PM
 */
?>
<div class="wrap">
    <h1>New Project Type</h1><br>
    <a class="page-title-action" href="<?php echo PJHtml::getPageUrl('ict-project-types-page');?>">Back To Project Types</a>
    <br><br>

    <?php PJHtml::wf_beginForm('post', PJHtml::adminUrl('ict-edit-project-type-page',[
        'id'=>$type['type_id']
    ]),'xhuma-projects-settings');?>

    <table class="form-table">
        <tbody>

        <tr>
            <th><label>Project Type</label></th>
            <td><?php echo PJHtml::wf_text_input('project_type',  esc_html($type['project_type']),array(
                    'style'=>'width:60%;',
                ));?></td>
        </tr>

        <tr>
            <th><label>Project Description</label></th>
            <td><?php echo PJHtml::wf_text_input('project_description',  esc_html($type['project_description']),array(
                    'style'=>'width:60%;',
                ));?></td>
        </tr>

        </tbody>
    </table>

    <?php echo PJHtml::wf_submitButton('ict_project_types_submit');?>

    <?php PJHtml::wf_endForm();?>

</div>
