<?php
PJHtml::wf_registerStyle('data-table-css', plugins_url( '/public/DataTables/datatables.css', __DIR__ ),
    '1.1');
PJHtml::wf_registerScript('data-table-js',
    plugins_url( '/public/DataTables/datatables.js', __DIR__ ),'1.0');
?>
<div class="wrap">
    <h1><?php echo $project['project_name'];?> Team Members</h1><br>
    <a class="page-title-action" href="<?php echo PJHtml::getPageUrl('ict-projects-main-page');?>">Back To Projects</a>
    <a class="page-title-action" href="<?php echo PJHtml::adminUrl('ict-new-project-team-member-page',[
        'id'=>$_GET['id'],
    ])?>">Add Team Member</a>
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
        <?php $tableRow = 1;?>
        <?php foreach( $teams as $team):?>
	        <?php
	        $projectTable = new PJModel('wp_ict_projects');
	        $project = $projectTable->findByPk('project_id',$team['project_id']);
	        ?>
            <tr data-team="<?php echo $team['team_id'];?>">
                <td><?php echo $tableRow;?></td>
                <td><a href="<?php echo PJHtml::adminUrl('ict-edit-team-member-page',[
                        'id'=>$team['team_id']
                    ]);?>">
                        <?php echo $team['title'] . ' '. $team['team_name'];?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo PJHtml::adminUrl('ict-edit-project-page',[
                        'id'=>$project['project_id']
                    ]);?>">
                        <?php echo $project['project_name'];?>
                    </a>
                </td>
                <td><?php echo PJHtml::wf_limitText($team['description'], 10);?></td>
                <td><?php echo $team['position'];?></td>
            </tr>
        <?php $tableRow++ ;?>
        <?php endforeach;?>
        </tbody>

    </table>
</div>
<script>
    jQuery(function($){
        $(document).ready( function () {
            var jTable = $('#table_teams').DataTable({
                rowReorder: true
            });

            jTable.on( 'row-reorder', function ( e, diff, edit ) {
                var updateOld =[];
                var updateNew =[];
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var row = jTable.row( diff[i].node ).node();
                    var teamId = row.getAttribute("data-team");
                    updateOld.push(teamId);
                    updateNew.push(diff[i].newData);
                }
                sendReOrderData(updateOld, updateNew);
            } );

            var sendReOrderData = function(oldPositions, newPositions){
                $.post("<?php echo admin_url( 'admin-ajax.php' ); ?>",{action:"ict_ajax_reorder_teams","rOld[]":oldPositions,"rNew[]":newPositions},function(data){
                });
            };

        } );

    })
</script>
