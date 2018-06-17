<?php
WfHtml::wf_registerStyle('data-table-css', plugins_url( '/public/DataTables/datatables.css', __DIR__ ),
    '1.1');
WfHtml::wf_registerScript('data-table-js',
    plugins_url( '/public/DataTables/datatables.js', __DIR__ ),'1.0');
?>
<div class="wrap">
    <h1>Team Members for Projects</h1><br>
    <a class="page-title-action" href="<?php echo WfHtml::getPageUrl('ict-new-team-member-page');?>">Add New</a>
    <br><br>
    <table id="table_teams" class="display wp-list-table widefat fixed">
        <thead>
        <tr>
            <td>#</td>
            <td>Team Member</td>
            <td>Project</td>
            <td>Description</td>
            <td>Position</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach( $teams as $team):?>
        <tr>
            <?php
                $projectTable = new WfModel('wp_ict_projects');
                $project = $projectTable->findByPk('project_id',$team['project_id']);

            ?>
            <td><?php echo $team['team_id'];?></td>
            <td><a href="<?php echo WfHtml::adminUrl('ict-edit-team-member-page',[
                    'id'=>$team['team_id']
                ]);?>">
                    <?php echo $team['title'] . ' '. $team['team_name'];?>
                </a>
            </td>
            <td>
                <a href="<?php echo WfHtml::adminUrl('ict-edit-project-page',[
                    'id'=>$project['project_id']
                ]);?>">
                    <?php echo $project['project_name'];?>
                </a>
            </td>
            <td><?php echo WfHtml::wf_limitText($team['description'], 10);?></td>
            <td><?php echo $team['position'];?></td>
        </tr>

        <?php endforeach;?>
        </tbody>

    </table>
</div>
<script>
    jQuery(function($){
        $(document).ready( function () {
            var jTable = $('#table_teams').DataTable({ "order": []});
        } );
    })
</script>
