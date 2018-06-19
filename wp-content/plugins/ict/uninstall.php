<?php
/**
 * Created by PhpStorm.
 * User: shady
 * Date: 6/17/18
 * Time: 6:39 PM
 */

require_once __DIR__ . '/helpers/PJModel.php';

if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();


ict_drop_created_tables();

function ict_drop_created_tables(){
    $model = new PJModel();
    $model->db()->query('DROP TABLE wp_ict_projects');
    $model->db()->query('DROP TABLE wp_ict_teams');
    $model->db()->query('DROP TABLE wp_ict_project_types');
}