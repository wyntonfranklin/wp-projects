<?php
PJHtml::wf_registerStyle('data-table-css', plugins_url( '/public/DataTables/datatables.css', __DIR__ ),
    '1.1');
PJHtml::wf_registerScript('data-table-js',
    plugins_url( '/public/DataTables/datatables.js', __DIR__ ),'1.0');
?>
<div class="wrap">
    <h1>Project Types Page</h1><br>
    <div id="col-container">
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap" style="background-color:#fff; padding:10px; border: 1px solid #ddd;">
                    <?php PJHtml::wf_beginForm('post',PJHtml::wf_getPageUrl('ict-project-types-page'),'xhuma-projects-settings');?>

                    <table class="form-table ">
                        <tbody>

                        <tr>
                            <th><label>Project Type</label></th>
                            <td><?php echo PJHtml::wf_text_input('project_type',  esc_html($options['api_url']),array(

                                ));?></td>
                        </tr>

                        <tr>
                            <th><label>Project Description</label></th>
                            <td><?php echo PJHtml::wf_text_input('project_description',  esc_html($options['api_url']),array(
                                ));?></td>
                        </tr>

                        </tbody>
                    </table>
                    <br>
                    <?php echo PJHtml::wf_submitButton('ict_project_types_submit');?>

                    <?php PJHtml::wf_endForm();?>

                </div>
            </div>
        </div>
        <div id="col-right">
            <div class="col-wrap">

                <table id="table_id" class="display wp-list-table widefat fixed">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>Type</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $types as $type):?>
                        <tr>
                            <td><?php echo $type['type_id'];?></td>
                            <td><?php echo $type['project_type'];?></td>
                            <td>
                                <a href="<?php echo PJHtml::adminUrl('ict-edit-project-type-page',[
                                    'id'=>$type['type_id']
                                ]);?>">
                                    <span title="Edit" class="dashicons dashicons-edit"></span>
                                </a>
                                &nbsp;
                                <a>
                                    <span title="Delete" class="dashicons dashicons-trash"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
