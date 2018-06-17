<?php
WfHtml::wf_registerStyle('data-table-css', plugins_url( '/public/DataTables/datatables.css', __DIR__ ),
    '1.1');
WfHtml::wf_registerScript('data-table-js',
    plugins_url( '/public/DataTables/datatables.js', __DIR__ ),'1.0');
?>
<div class="wrap">
    <h1>Projects page</h1><br>
    <a class="page-title-action" href="<?php echo WfHtml::getPageUrl('ict-new-project-page');?>">Add New</a>
    <br><br>
    <table id="table_id" class="display wp-list-table widefat fixed">
        <thead>
        <tr>
            <td>#</td>
            <td>Project Name</td>
            <td>Type of Project</td>
            <td>Client</td>
            <td>Project Team</td>
            <td>Start Date</td>
            <td>End Date</td>
            <td>Reference</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach( $projects as $project):?>
        <tr>
            <td><?php echo $project['project_id'];?></td>
            <td><a href="<?php echo WfHtml::adminUrl('ict-edit-project-page',[
                    'id'=>$project['project_id']
                ]);?>">
                    <?php echo $project['project_name'];?>
                    <?php if( $project['published']== 1):?>
                        <span title="Published">(P)</span>
                    <?php endif;?>
                </a>
            </td>
            <td><?php echo $project['type'];?></td>
            <td><?php echo $project['client'];?></td>
            <?php

                $teamDb = new WfModel('wp_ict_teams');
                $teamCount = $teamDb->getCount('WHERE project_id='.$project['project_id'])

            ?>
            <td><a href="<?php echo WfHtml::adminUrl('ict-project-team-members',[
                'id'=>$project['project_id'],
                ])?>">View (<?php echo $teamCount;?>)</a></td>
            <td><?php echo $project['start_date'];?></td>
            <td><?php echo $project['end_date'];?></td>
            <td><a target="_blank" href="<?php echo $project['ref_url'];?>">
                    <span class="dashicons dashicons-paperclip"></span></a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>

    </table>
</div>
<script>
    jQuery(function($){
        $(document).ready( function () {
           var jTable = $('#table_id').DataTable();
        } );
    })
</script>
