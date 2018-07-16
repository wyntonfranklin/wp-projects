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
wp_enqueue_script('short-code-script',
	plugins_url( '/public/js/ict_projects.js', __DIR__ ),
	array( 'jquery' ),
	'1.0'
);
?>

<!--<h1>ShortCode Title</h1> -->

<div class="ict-project-table-container">
    <table id="ict-projects-table" class="ict-projects-table">
        <thead>
        <tr>
            <th>Project Name</th>
            <th>Type of Project</th>
            <th>Client</th>
            <th>Project Team</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reference</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach( $projects as $project ):?>
        <tr>
            <td><a href="#" class="proj-desc" data-project="<?php echo $project['project_id'];?>">
                    <?php echo stripslashes($project["project_name"]);?>
                </a>
            </td>
            <td><?php echo stripslashes($project["type"]);?></td>
            <td><?php echo stripslashes($project["client"]);?></td>
            <?php

            $teamDb = new PJModel('wp_ict_teams');
            $teamCount = $teamDb->getCount('WHERE project_id='.$project['project_id'])

            ?>
            <td>
                <a data-id="<?php echo $project['project_id'];?>" data-project="<?php echo stripslashes($project['project_name']);?>" href="#" class="view-team">
                    View (<?php echo $teamCount;?>)</a>
            </td>
            <td><?php echo $project["start_date"];?></td>
            <td><?php
                if( $project["current"] == 1 ){
	                echo "Present";
                }else{
	                echo $project["end_date"];
                } ?>
            </td>
            <td>
                <?php if(!empty($project["ref_url"])):?>
                    <a target="_blank" href="<?php echo $project['ref_url'];?>">View</a>
                <?php else:?>
                <span>N/A</span>
                <?php endif;?>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<div class="white-popup-block no-show-popup" id="modal-popup">
    <div class="white-popup-header">
        <h3 id="team-title">Project Name</h3>
    </div>
    <div>
        <table class="project-team-table" style="width: 100%; margin-top:20px; margin-bottom: 50px;">
            <thead>
                <tr>
                    <th>Team Member</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody id="teams-content">
            <tr>
                <td colspan="2">Loading Content...</td>
            </tr>
            </tbody>
        </table>
    </div>
    <button title="Close" type="button" class="mfp-close" style="color: #333!important;">&#215;</button>
</div>

<div class="white-popup-block no-show-popup" id="project-popup">
    <div class="white-popup-header">
        <h3 id="project-title">Project Name</h3>
    </div>
    <div>
        <h4>Overview</h4>
        <div id="project-description" style="margin-bottom: 30px;">
            <span>Loading Content...</span>
        </div>
    </div>
    <button title="Close" type="button" class="mfp-close" style="color: #333!important;">&#215;</button>
</div>
