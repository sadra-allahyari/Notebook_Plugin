<?php
function create_contact_table(){
    global $table_prefix, $wpdb;
    $table_name = $table_prefix."contacts";

    if($wpdb->get_var("show tables like '$table_name'") !=$table_name){
        $sql = "CREATE TABLE `$table_name` (";
        $sql.= "`Id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,";
        $sql.= "`FirstName` text NOT NULL,";
        $sql.= "`LastName` text NOT NULL,";
        $sql.= "`MobileNumber` text NOT NULL UNIQUE,";
        $sql.= "`HomeNumber` text NOT NULL,";
        $sql.= "`Email` text NOT NULL UNIQUE,";
        $sql.= "`Fax` text NOT NULL,";
        $sql.= "`Birthday` text NOT NULL,";
        $sql.= "`Gender` text NOT NULL,";
        $sql.= "`Category` text NOT NULL";
        $sql.= ") ENGINE=MyISAM DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1;";
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

?>