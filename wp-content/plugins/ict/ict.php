<?php
/*
Plugin Name: ICT Projects
Plugin URI: http://www.ict.co.tt
Description: A plugin to display projects.
Author: Wynton Franklin
Version: 0.0.3
Author URI: http://www.ict.co.tt
*/

// require helper classes
require_once __DIR__ . '/helpers/PJHtml.php';
require_once __DIR__ . '/helpers/PJModel.php';
//require_once __DIR__ .'/includes/settings.php';  // Not used currently

if ( ! defined( 'WPINC' ) ) {
	die;
}


// Activation hook. This runs when the project is activated.
register_activation_hook(__FILE__,'ict_projects_set_default_options');


// On activatation. Register default api options.
function ict_projects_set_default_options(){
	if( get_option('ict_projects_options') === false ){
		$new_options['api_url'] = 'http://ict.ict.co/v0/api/events?per_page=50';
		add_option('ict_projects_options', $new_options);
	}
	ict_create_tables();
}

// Add the ajax_url globally to be accessible in all scripts.
add_action( 'wp_head', 'ict_declare_ajaxurl' );

// All init functions
function ict_init(){
	add_action('wp_ajax_nopriv_ict_ajax_projects', 'ict_ajax_projects');
	add_action('wp_ajax_ict_ajax_projects', 'ict_ajax_projects' );
	add_action('admin_menu','ict_projects_admin_menu');
    add_shortcode( 'ict-projects','ict_project_short_code_view');

}

add_action('init', 'ict_init');


// display the experience table
function ict_display_experience_table( $atts = [], $content = null, $tag = '' ){
	ict_register_experience_table_scripts();
	return PJHtml::wf_render('ict_table_view',[],false);
}

// register scripts for experience table
function ict_register_experience_table_scripts(){
	PJHtml::wf_registerStyle('modal-style',plugins_url( '/public/css/magnific-popup.css', __FILE__ ),
		'1.1');
	PJHtml::wf_registerStyle('general-style',plugins_url( '/public/css/ict.css', __FILE__ ),
		'1.1');
	PJHtml::wf_registerScript('angular',
		plugins_url( '/public/js/angular.min.js', __FILE__ ),'1.0');
	wp_enqueue_script('modal',
		plugins_url( '/public/js/jquery.magnific-popup.min.js', __FILE__ ),
		array( 'jquery' ),
		'1.0'
	);
	wp_enqueue_script('experience-table',
		plugins_url( '/public/js/experience-table.js', __FILE__ ),
		array( 'jquery' ),
		'1.0'
	);
}

// Call the api and return the data
function ict_ajax_projects(){
	$data = ict_apiRequest( ict_get_api_url() );
	$limit = count($data["results"]);
	$events = array();

	for($i=0; $i<= $limit-1; $i++) {
		$events[] = $data["results"][$i]["events"];
	}

	echo json_encode($events);

	exit();
}


// Api request function
function ict_apiRequest($url){

	$request = wp_remote_get($url);

	if( is_wp_error( $request ) ) {
		echo $request->get_error_message(); // Bail early
	}

	$body = wp_remote_retrieve_body( $request );

	$data = json_decode( $body ,true);

	if( ! empty( $data ) ) {
		return $data;
	}
}


// function to render the ajax script. Find in layouts folder
function ict_declare_ajaxurl() {
	PJHtml::wf_render('ajax_url',[]);
}

function ict_create_tables(){
    ict_create_projects_table();
    ict_create_team_table();
    ict_create_project_types_table();
}

function ict_create_projects_table(){
    $model = new PJModel();
    $projects_table = 'CREATE TABLE IF NOT EXISTS `wp_ict_projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(165) DEFAULT NULL,
  `project_description` longtext,
  `type` varchar(65) DEFAULT NULL,
  `client` varchar(165) DEFAULT NULL,
  `team` varchar(65) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `ref_url` varchar(165) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
    $model->db()->query($projects_table);
}

function ict_create_team_table(){
    $model = new PJModel();
    $team_table = 'CREATE TABLE IF NOT EXISTS `wp_ict_teams` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `team_name` varchar(165) DEFAULT NULL,
  `description` longtext,
  `contact` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `position` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
    $model->db()->query($team_table);
}

function ict_create_project_types_table(){
    $model = new PJModel();
    $types_table = 'CREATE TABLE IF NOT EXISTS `wp_ict_project_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_type` varchar(65) DEFAULT NULL,
  `project_description` varchar(165) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
    $model->db()->query($types_table);
}


// Create a admin menu for projects.
function ict_projects_admin_menu(){
	add_menu_page('Projects Page','All Projects',
		'manage_options','ict-projects-main-page','ict_render_projects_page',
		'dashicons-portfolio');

    add_submenu_page('ict-projects-main-page','Teams','Teams',
        'manage_options','ict-projects-teams-page','ict_render_projects_teams_page');

    add_submenu_page('ict-projects-main-page','Project Types','Project Types',
        'manage_options','ict-project-types-page','ict_render_project_types_page');

	add_submenu_page('ict-projects-main-page','Settings','Settings',
		'manage_options','ict-projects-settings-page','ict_render_projects_settings_page');

	add_submenu_page('','New Project','New Project',
		'manage_options','ict-new-project-page','ict_render_new_projects_page');

    add_submenu_page('','Edit Project','Edit Project',
        'manage_options','ict-edit-project-page','ict_render_edit_projects_page');

    add_submenu_page('','New Team Member','New Team Member',
        'manage_options','ict-new-team-member-page','ict_render_new_team_member_page');

    add_submenu_page('','Edit Team Member','Edit Team Member',
        'manage_options','ict-edit-team-member-page','ict_render_edit_team_member_page');

    add_submenu_page('','Project Team Members','Project Team Members',
        'manage_options','ict-project-team-members','ict_render_project_team_page');

    add_submenu_page('','New Project Team Member','New Project Team Member',
        'manage_options','ict-new-project-team-member-page','ict_render_new_project_team_member_page');

    add_submenu_page('','Edit Project Type','Edit Project Type',
        'manage_options','ict-edit-project-type-page','ict_render_edit_project_type_page');

    
}


function ict_render_projects_page(){
    $model = new PJModel('wp_ict_projects');
	PJHtml::wf_render('projects_page',['projects'=>$model->findAll()]);
}

function ict_render_projects_teams_page(){
    $model = new PJModel('wp_ict_teams');
    PJHtml::wf_render('teams_page',['teams'=>$model->findAll('ORDER BY team_id DESC')]);
}

function ict_render_project_types_page(){
    $model = new PJModel('wp_ict_project_types');
    if(isset($_POST['ict_project_types_submit'])){
        $model->insert(array(
            'project_type' => $_POST['project_type'],
            'project_description' => $_POST['project_description'],
        ));
        echo PJHtml::formMessage('Project Type Created');
    }
    PJHtml::wf_render('project_types_page',['types'=>$model->findAll()]);
}

// Show the projects settings page.
function ict_render_projects_settings_page(){
	$options = get_option('ict_projects_options');
	if(isset($_POST['api_url'])){
		$options['api_url'] = sanitize_text_field($_POST['api_url']);
		update_option('ict_projects_options',$options);
		echo PJHtml::formMessage('Options Updated');
	}
	PJHtml::wf_render('projects_settings',['options'=>$options]);
}

function ict_render_new_projects_page(){
    $model = new PJModel('wp_ict_projects');
    $ict_project = null;
    if(isset($_POST['ict_projects_submit'])){
        $model->insert(array(
            'project_name' => $_POST['project_name'],
            'project_description' => $_POST['project_description'],
            'type' => $_POST['project_type'],
            'client' => $_POST['project_client'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'ref_url' => $_POST['ref_url'],
            'published' => (!empty($_POST['published']) ? 1 : 0 )
        ));
        echo PJHtml::formMessage('Project Created');
    }
	PJHtml::wf_render('new_projects_page',['model'=>$model]);
}

function ict_render_edit_projects_page(){
    $project = null;
    $model = new PJModel('wp_ict_projects');
    if(isset($_GET['id'])){
        $project = $model->findByPk("project_id",$_GET['id']);
    }
    if(isset($_POST['ict_projects_update_submit'])){
        $project['project_name'] = $_POST['project_name'];
        $project['project_description'] = $_POST['project_description'];
        $project['type'] = $_POST['project_type'];
        $project['client'] = $_POST['project_client'];
        $project['start_date'] = $_POST['start_date'];
        $project['end_date'] = $_POST['end_date'];
        $project['ref_url'] = $_POST['ref_url'];
        $project['published'] = (!empty($_POST['published']) ? 1 : 0 );
        $model->update($project,'project_id',$project['project_id']);
        echo PJHtml::formMessage('Project updated');

    }
    PJHtml::wf_render('edit_projects_page',['project'=>$project]);
}

function ict_render_new_team_member_page(){
    $model = new PJModel('wp_ict_teams');
    $ict_team = null;
    if(isset($_POST['ict_teams_submit'])){
        $model->insert(array(
            'project_id' => $_POST['project'],
            'title' => $_POST['title'],
            'team_name' => $_POST['name'],
            'description' => $_POST['description'],
            'contact' => $_POST['contact'],
            'email' => $_POST['email'],
            'position' => $_POST['position'],
        ));
        echo PJHtml::formMessage('Team Created');
    }
    PJHtml::wf_render('new_team_member_page');
}

function ict_render_edit_team_member_page(){
    $team = null;
    $model = new PJModel('wp_ict_teams');
    if(isset($_GET['id'])){
        $team = $model->findByPk("team_id",$_GET['id']);
    }
    if(isset($_POST['ict_teams_update_submit'])){
        $team['title'] = $_POST['title'];
        $team['team_name'] = $_POST['name'];
        $team['description'] = $_POST['description'];
        $team['position'] = $_POST['position'];
        $team['project_id'] = intval($_POST['project']);
        $team['contact'] = $_POST['contact'];
        $team['email'] = $_POST['email'];
        $model->update($team,'team_id',$team['team_id']);
        echo PJHtml::formMessage('Team updated');

    }
    PJHtml::wf_render('edit_team_member_page',['team'=>$team]);
}

function ict_render_project_team_page(){
    $model = new PJModel('wp_ict_teams');
    $projTable = new PJModel('wp_ict_projects');
    $project = $projTable->findByPk('project_id',$_GET['id']);
    PJHtml::wf_render('project_team_page',[
        'teams'=>$model->findAll('WHERE project_id='.$_GET['id']),
        'project' => $project
    ]);
}

function ict_render_new_project_team_member_page(){
    $model = new PJModel('wp_ict_teams');
    $ict_team = null;
    if(isset($_POST['ict_teams_submit'])){
        $model->insert(array(
            'project_id' => $_POST['project'],
            'title' => $_POST['title'],
            'team_name' => $_POST['name'],
            'description' => $_POST['description'],
            'contact' => $_POST['contact'],
            'email' => $_POST['email'],
            'position' => $_POST['position'],
        ));
        echo PJHtml::formMessage('Team Created');
    }
    PJHtml::wf_render('new_project_team_member');
}


function ict_render_edit_project_type_page(){
    $type = null;
    $model = new PJModel('wp_ict_project_types');
    if(isset($_GET['id'])){
        $type = $model->findByPk("type_id",$_GET['id']);
    }
    if(isset($_POST['ict_project_types_submit'])){
        $type['project_type'] = $_POST['project_type'];
        $type['project_description'] = $_POST['project_description'];
        $model->update($type,'type_id',$type['type_id']);
        echo PJHtml::formMessage('Project Type updated');

    }
    PJHtml::wf_render('new_project_type_page',['type'=>$type]);
}


function ict_project_short_code_view( $atts = [], $content = null, $tag = '' ){
    $a = shortcode_atts( array(
        'name' => 'dashboard',
    ), $atts );
    $model = new PJModel('wp_ict_projects');
    $projects = $model->findAll('WHERE published=1');
    PJHtml::wf_render('shortcode_view',['attributes'=>$a,'projects'=>$projects]);
}



// Get the api from wordpress options api.
function ict_get_api_url(){
	$options = get_option('ict_projects_options');
	return $options['api_url'];
}