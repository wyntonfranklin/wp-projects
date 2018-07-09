<?php
PJHtml::wf_registerStyle('data-table-css', plugins_url( '/public/DataTables/datatables.css', __DIR__ ),
    '1.1');
PJHtml::wf_registerScript('data-table-js',
    plugins_url( '/public/DataTables/datatables.js', __DIR__ ),'1.0');
?>
<div class="wrap">
    <h1>Projects page</h1><br>
    <a class="page-title-action" href="<?php echo PJHtml::getPageUrl('ict-new-project-page');?>">Add New</a>
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
            <td>Status</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach( $projects as $project):?>
        <tr>
            <td><?php echo $project['project_id'];?></td>
            <td><a href="<?php echo PJHtml::adminUrl('ict-edit-project-page',[
                    'id'=>$project['project_id']
                ]);?>">
                    <?php echo stripslashes($project['project_name']);?>
                </a>
            </td>
            <td><?php echo $project['type'];?></td>
            <td><?php echo stripslashes($project['client']);?></td>
            <?php

                $teamDb = new PJModel('wp_ict_teams');
                $teamCount = $teamDb->getCount('WHERE project_id='.$project['project_id'])

            ?>
            <td><a href="<?php echo PJHtml::adminUrl('ict-project-team-members',[
                'id'=>$project['project_id'],
                ])?>">View (<?php echo $teamCount;?>)</a></td>
            <td><?php echo $project['start_date'];?></td>
            <td><?php echo $project['end_date'];?></td>
            <td>
                <?php if( $project['published']== 1):?>
                    <span title="Published" class="dashicons dashicons-visibility"></span>
                <?php else:?>
                    <span title="Hidden" class="dashicons dashicons-hidden"></span>
                <?php endif;?>
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
