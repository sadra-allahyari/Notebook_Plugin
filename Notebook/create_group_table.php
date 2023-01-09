<?php
function create_group_table(){
    global $table_prefix, $wpdb;
    $table_name = $table_prefix."groups";

    if($wpdb->get_var("show tables like '$table_name'") !=$table_name){
        $sql = "CREATE TABLE `$table_name` (";
        $sql.= "`Id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,";
        $sql.= "`GroupName` text NOT NULL UNIQUE,";
        $sql.= "`Members` text NOT NULL";
        $sql.= ") ENGINE=MyISAM DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1;";
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

?>