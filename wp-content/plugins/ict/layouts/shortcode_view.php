<?php
WfHtml::wf_registerStyle('general-style',plugins_url( '/public/css/ict-projects.css', __DIR__ ),
    '1.1');
WfHtml::wf_registerStyle('data-table-css', plugins_url( '/public/DataTables/datatables.css', __DIR__ ),
    '1.1');
WfHtml::wf_registerScript('data-table-js',
    plugins_url( '/public/DataTables/datatables.js', __DIR__ ),'1.0');
WfHtml::wf_registerStyle('modal-style',plugins_url( '/public/css/magnific-popup.css', __DIR__ ),
    '1.1');
wp_enqueue_script('modal',
    plugins_url( '/public/js/jquery.magnific-popup.min.js', __DIR__ ),
    array( 'jquery' ),
    '1.0'
);
?>
<h1>ShortCode Title</h1>

<div class="ict-project-table">
    <table id="ict-projects-table" class="display wp-list-table widefat fixed">
        <thead>
        <tr>
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
        <?php foreach( $projects as $project ):?>
        <tr>
            <td><?php echo $project["project_name"];?></td>
            <td><?php echo $project["type"];?></td>
            <td><?php echo $project["client"];?></td>
            <?php

            $teamDb = new WfModel('wp_ict_teams');
            $teamCount = $teamDb->getCount('WHERE project_id='.$project['project_id'])

            ?>
            <td><a href="#" class="view-team">View (<?php echo $teamCount;?>)</a></td>
            <td><?php echo $project["start_date"];?></td>
            <td><?php echo $project["end_date"];?></td>
            <td><a target="_blank" href="<?php echo $project['ref_url'];?>">
                 View</a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<div class="white-popup-block no-show-popup" id="modal-popup">
    <div class="white-popup-header">
        <h3 id="md-title">header content</h3>
    </div>
    <div style="margin-bottom: 10px; text-align: center;">
        <img src="http://ict.xhuma.co/event_logos/blue_background.jpg" width="50%">
    </div>
    <div>
        <table class="table table-user-information">
            <tbody>
            <tr>
                <td><b>Team Title:</b> &nbsp;<span id="team-job">A Team Tile</span></td>
                <td><b>Team Description:</b> &nbsp; <span id="team-description">A descripton of team member</span></td>
            </tr>
            <tr>
                <td colspan="2"><b>Team Status:</b> <span id="team-experience">A place for stats</span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <button title="Close" type="button" class="mfp-close">&#215;</button>
</div>

<script>
    jQuery(function($){
        var el = $('#modal-popup');
        $(document).ready( function () {
            var jTable = $('#ict-projects-table').DataTable();
        } );

        $('.view-team').on('click',function(){
            el.removeClass('no-show-popup');
            el.addClass('show-popup');
            jQuery.magnificPopup.open({
                items: {
                    src: '#modal-popup',
                    type: 'inline'
                }
            });
            return false;
        });

    });
</script>