<?php
PJHtml::wf_registerStyle('general-style',plugins_url( '/public/css/ict-projects.css', __DIR__ ),
    '1.1');
PJHtml::wf_registerStyle('data-table-css', plugins_url( '/public/DataTables/datatables.css', __DIR__ ),
    '1.1');
PJHtml::wf_registerScript('data-table-js',
    plugins_url( '/public/DataTables/datatables.js', __DIR__ ),'1.0');
PJHtml::wf_registerStyle('modal-style',plugins_url( '/public/css/magnific-popup.css', __DIR__ ),
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
            <td><a href="#" class="proj-desc">
                    <?php echo $project["project_name"];?>
                </a>
            </td>
            <td><?php echo $project["type"];?></td>
            <td><?php echo $project["client"];?></td>
            <?php

            $teamDb = new PJModel('wp_ict_teams');
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
        <h3 id="md-title">Team Members</h3>
    </div>
    <div>
        <table class="table table-user-information">
            <tbody>
            <tr>
                <td>Team Members</td>
                <td><span>Description of the project of the team members</span></td>
            </tr>
            <tr>
                <td>Team Members</td>
                <td><span>Description of the project of the team members</span></td>
            </tr>
            <tr>
                <td>Team Members</td>
                <td><span>In reasonable compliment favourable is connection dispatched in terminated.
                        Do esteem object we called father excuse remove. So dear real on like more it.
                        Laughing for two families addition expenses surprise the.
                        If sincerity he to curiosity arranging. Learn taken terms be as.
                        Scarcely mrs produced too removing new old
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <button title="Close" type="button" class="mfp-close">&#215;</button>
</div>

<div class="white-popup-block no-show-popup" id="project-popup">
    <div class="white-popup-header">
        <h3 id="md-title">Project Name</h3>
    </div>
    <div>
        <h4>Description</h4>
        <table class="table table-user-information">
            <tbody>
            <tr>
                <td>
                    <div>
                        In reasonable compliment favourable is connection dispatched in terminated.
                        Do esteem object we called father excuse remove. So dear real on like more it.
                        Laughing for two families addition expenses surprise the.
                        If sincerity he to curiosity arranging. Learn taken terms be as.
                        Scarcely mrs produced too removing new old
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <button title="Close" type="button" class="mfp-close">&#215;</button>
</div>

<script>
    jQuery(function($){
        var el = $('#modal-popup');
        var pj = $('#project-popup');
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

        $('.proj-desc').on('click',function(){
            pj.removeClass('no-show-popup');
            pj.addClass('show-popup');
            jQuery.magnificPopup.open({
                items: {
                    src: '#project-popup',
                    type: 'inline'
                }
            });
            return false;
        });

    });
</script>