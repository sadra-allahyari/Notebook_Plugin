<?php
/**
 * Plugin Name: contacts
 * Plugin URI:
 * Description: a plugin for show, edit, export, import and ... contacts
 * Version: 1.0
 * Author: sadra
 * Author URI:
 */



add_action("admin_menu", "add_menu_func_main");
include "create_contact_table.php";
include "create_group_table.php";
register_activation_hook(__FILE__, 'create_contact_table');
register_activation_hook(__FILE__, 'create_group_table');

function add_menu_func_main(){
    add_menu_page("contacts", "contacts", "manage_options", "contacts_table", "contacts_table_page", "dashicons-admin-users", 3);
    add_submenu_page("contacts_table", "Submenu Page", "add contact", "manage_options", "add_contact", "add_contact_content");
    add_submenu_page("contacts_table", "Submenu Page", "import contact", "manage_options", "import_contact", "import_contact_content");
    add_submenu_page("contacts_table", "Submenu Page", "export contact", "manage_options", "export_contact", "export_contact_content");
    add_submenu_page("contacts_table", "Submenu Page", "edit contact", "manage_options", "edit_contact", "edit_contact_content");
    add_submenu_page("contacts_table", "Submenu Page", "groups", "manage_options", "groups", "groups_content");
    add_submenu_page("contacts_table", "Submenu Page", "create group", "manage_options", "create_group", "create_group_content");
    add_submenu_page("contacts_table", "Submenu Page", "edit group", "manage_options", "edit_group", "edit_group_content");
}


function contacts_table_page() {
?>

<!DOCTYPE html>
<html>
    <head>
            <style>

                table {
                    border-collapse: collapse;
                    width: 70%;
                }

                th, td {
                    padding: 8px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }

                tr:hover {background-color: #ccccff;}

                form.example button {
                    float: left;
                    width: 20%;
                    padding: 10px;
                    background: #2196F3;
                    color: white;
                    font-size: 17px;
                    border: 1px solid grey;
                    border-left: none;
                    cursor: pointer;
                }

            </style>
    </head>

    <body>
        <h1>Contacts</h1>
        <form method = "POST" action="<?php echo admin_url('admin.php?page=contacts_table');?>">

            <table>

                        <thead>
                            <tr>
                                <th><button name="delete_button">Delete</button></th>
                                <td><button name="edit_button">Edit</button></td>
                                <td>name</td>
                                <td>Last Name</td>
                                <td>Mobile Number</td>
                                <td>Home Number</td>
                                <td>Email</td>
                                <td>Fax</td>
                                <td>Birthday</td>
                                <td>Gender</td>
                                <td>Category</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                global $wpdb,$table_prefix;
                                $table_name=$table_prefix."contacts";
                                if(isset($_POST['delete_button']) AND isset($_POST['select'])){
                                    for($i=0; $i<count($_POST['select']); $i++ ){
                                        $select_Id = $_POST['select'][$i];
                                        $wpdb->delete($table_name,
                                                    array(
                                                        'Id' => $select_Id
                                                    )
                                        );
                                    }
                                }

                                if(isset($_POST['edit_button']) AND isset($_POST['select'])){
                                    ?>
                                        <meta http-equiv="Refresh" content="0; url='admin.php?page=edit_contact&ID=<?php print($_POST['select'][0]); ?>'" />
                                    <?php
                                }

                                $result=$wpdb->get_results("SELECT * FROM $table_name ORDER BY `wp_contacts`.`LastName`,`wp_contacts`.`FirstName` ASC");
                                foreach($result as $row){
                                    $Id = $row->Id;
                            ?>
                                    <tr>
                                        <td><input type = "checkbox" name = "select[]" value="<?php echo $Id; ?>"></td>
                                        <td></td>
                                        <th><?php echo $row->FirstName ?></th>
                                        <th><?php echo $row->LastName ?></th>
                                        <th><?php echo $row->MobileNumber ?></th>
                                        <th><?php echo $row->HomeNumber ?></th>
                                        <th><?php echo $row->Email ?></th>
                                        <th><?php echo $row->Fax ?></th>
                                        <th><?php echo $row->Birthday ?></th>
                                        <th><?php echo $row->Gender ?></th>
                                        <th><?php echo $row->Category ?></th>
                                    </tr>
                            <?php
                                }

                            ?>
                        </tbody>
            </table>
        </form>
    </body>
</html>

<?php
}


function add_contact_content() {
?>

<!DOCTYPE html>
    <html>
    <head>
    </head>
        <body>
            <div> 
                    <h1>Add Contact</h1>
    
                <form name="Contact" method="post">

                    <p>
                    <label for="Name">First Name </label>
                    <input type="text" name="Name" id="Name" minlength="1" required>
                    </p>

                    <p>
                    <label for="FamilyName">Family Name </label>
                    <input type="text" name="FamilyName" id="FamilyName" minlength="1" required>
                    </p>

                    <p>
                    <label for="MobileNumber">Mobile Number</label>
                    <input type="text" name="MobileNumber" id="MobileNumber" placeholder="09123456789" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  minlength="11" maxlength="11" required >
                    </p>

                    <p>
                    <label for="HomeNumber">Home Number</label>
                    <input type="text" name="HomeNumber" id="HomeNumber" placeholder="021-23456789" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   minlength="11" maxlength="11" required >
                    </p>

                    <p>
                    <label for="Email">E-mail</label>
                    <input type="email" name="Email" id="Email" minlength="5" required>
                    </p>

                    <p>
                    <label for="Fax">Fax</label>
                    <input type="text" name="Fax" id="Fax">
                    </p>

                    <p>
                    <label for="Birthday">Birthday</label>
                    <input type="date" name="Birthday" id="Birthday" required>
                    </p>

                    <p>Gender<br>
                    <input type="radio" name="Gender" id="Male" value="Male" required>
                    <label for="Gender">Male</label><br>
                    <input type="radio" name="Gender" id="Female" value="Female" required>
                    <label for="Gender">Female</label><br>
                    </p>
    
                    <p>Choose your Category:</p>
                    <input type="checkbox" name="Category" id="Type 1" value="Type 1" >
                    <label for="Category">Type 1</label>
                    <input type="checkbox" name="Category" id="Type 2" value="Type 2">
                    <label for="Category">Type 2</label>

                    <p>&nbsp;</p>

                    <input type="submit" value="Submit" name="contacts_submit_button">

                </form>
            </div>
        </body>
</html>

<?php
}   
    
    if(isset($_POST["contacts_submit_button"])){
    
        global $wpdb,$table_prefix;
        $table_name=$table_prefix."contacts";
    
        $FirstName = $_POST['Name'];
        $LastName = $_POST['FamilyName'];
        $MobileNumber = $_POST['MobileNumber'];
        $HomeNumber = $_POST['HomeNumber'];
        $Email = $_POST['Email'];
        $Fax = $_POST['Fax'];
        $Birthday = $_POST['Birthday'];
        $Gender = $_POST['Gender'];
        $Category = $_POST['Category'];
    
        $wpdb->insert($table_name,
                        array(
                            'FirstName'=>$FirstName,
                            'LastName'=>$LastName,
                            'MobileNumber'=>$MobileNumber,
                            'HomeNumber'=>$HomeNumber,
                            'Email'=>$Email,
                            'Fax'=>$Fax,
                            'Birthday'=>$Birthday,
                            'Gender'=>$Gender,
                            'Category'=>$Category
                        ),
                        array(
                            '%s', //use for string format
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s'
                        )
        );
    }


function import_contact_content() {
?>

<!DOCTYPE html>
    <html>
        <head>
        </head>

        <body>
            <h1>Import Contacts</h1>
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="chooseFile" id="chooseFile">
                <input type="submit" name="upload" class="form-control btn-warning">
            </form>
        </body>
    </html>

<?php
    if(isset($_POST['upload'])){

        global $wpdb,$table_prefix;
        $table_name=$table_prefix."contacts";

        $file = $_FILES['chooseFile']['name'];
        $file_data = $_FILES['chooseFile']['tmp_name'];
        $handle = fopen($file_data, "r");
        $c = 0;
        while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
          $FirstName = $filesop[0];
          $LastName = $filesop[1];
          $MobileNumber = $filesop[2];
          $HomeNumber = $filesop[3];
          $Email = $filesop[4];
          $Fax = $filesop[5];
          $Birthday = $filesop[6];
          $Gender = $filesop[7];
          $Category = $filesop[8];


          $data = array(
            'Id'=>'0',
            'FirstName' => $FirstName,
            'LastName' => $LastName,
            'MobileNumber' => $MobileNumber,
            'HomeNumber' => $HomeNumber,
            'Email' => $Email,
            'Fax' => $Fax,
            'Birthday' => $Birthday,
            'Gender' => $Gender,
            'Category' => $Category,
          );

          $wpdb->insert( $table_name , $data );
        }
    }
}


function export_contact_content() {

    global $wpdb,$table_prefix;
    $table_name=$table_prefix."contacts";
    $filename = "contacts.csv";

    // file creation
    $file = fopen($filename,"w+");

    $result = $wpdb->get_results("SELECT FirstName, LastName, MobileNumber, HomeNumber, Email, Fax, Birthday, Gender, Category FROM $table_name", ARRAY_A);
    foreach ($result as $row){
        fputcsv($file ,$row, ",");
    }
    fclose($file);
?>

<!DOCTYPE html>
    <html>
        <head>
        </head>

        <body>
            <h1>Export Contacts</h1>
            <input type="button" onclick="location.href='contacts.csv';" value="Export" />
        </body>
    </html>

<?php
}


function edit_contact_content() {

        if(!isset($_GET['ID'])){
            print("you can't use this page directly! :)");
            exit;
        }
        global $wpdb,$table_prefix;
        $table_name=$table_prefix."contacts";

        $result=$wpdb->get_results("SELECT * FROM $table_name WHERE Id='".$_GET['ID']."'");
        foreach($result as $row){
            $Id = $row->Id;
        }
        
                            
?>

<!DOCTYPE html>
    <html>
        <head>
        </head>
        <body>
            <div> 
                    <h1>Edit Contact</h1>
                <?php
                    if(!isset($row->FirstName)){
                        ?>
                        could not find the contant you wanted! :(
                        <meta http-equiv="Refresh" content="5; url='admin.php?page=contacts_table'" />
                        <?php
                        exit;

                    }
                    ?>
                   


                <form name="Contact" method="post">

                    <p>
                    <label for="Name">First Name </label>
                    <input type="text" name="Name" id="Name" value="<?php echo $row->FirstName ?>" minlength="1" required>
                    </p>

                    <p>
                    <label for="FamilyName">Family Name </label>
                    <input type="text" name="FamilyName" id="FamilyName" value="<?php echo $row->LastName ?>" minlength="1" required>
                    </p>

                    <p>
                    <label for="MobileNumber">Mobile Number</label>
                    <input type="text" name="MobileNumber" id="MobileNumber" value="<?php echo $row->MobileNumber ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  minlength="11" maxlength="11" required >
                    </p>

                    <p>
                    <label for="HomeNumber">Home Number</label>
                    <input type="text" name="HomeNumber" id="HomeNumber" value="<?php echo $row->HomeNumber ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   minlength="11" maxlength="11" required >
                    </p>

                    <p>
                    <label for="Email">E-mail</label>
                    <input type="email" name="Email" id="Email" value="<?php echo $row->Email ?>" minlength="5" required>
                    </p>

                    <p>
                    <label for="Fax">Fax</label>
                    <input type="text" name="Fax" id="Fax" value="<?php echo $row->Fax ?>">
                    </p>

                    <p>
                    <label for="Birthday">Birthday</label>
                    <input type="date" name="Birthday" id="Birthday" value="<?php echo $row->Birthday ?>" required>
                    </p>

                    <p>Gender<br>
                    <input type="radio" name="Gender" id="Male" value="Male" <?php echo $row->Gender=="Male" ? 'checked' : '';?> required>
                    <label for="Gender">Male</label><br>
                    <input type="radio" name="Gender" id="Female" value="Female" <?php echo $row->Gender=="Female" ? 'checked' : '';?> required>
                    <label for="Gender">Female</label><br>
                    </p>
    
                    <p>Choose your Category:</p>
                    <input type="checkbox" name="Category" id="Type 1" value="Type 1" <?php echo $row->Category=="Type 1" ? 'checked' : '';?>>
                    <label for="Category">Type 1</label>
                    <input type="checkbox" name="Category" id="Type 2" value="Type 2" <?php echo $row->Category=="Type 2" ? 'checked' : '';?>>
                    <label for="Category">Type 2</label>

                    <p>&nbsp;</p>

                    <input type="submit" value="Submit" name="contacts_edit_button">

                </form>
            </div>
        </body>
</html>

<?php
}
    
    if(isset($_POST["contacts_edit_button"])){
    
        global $wpdb,$table_prefix;
        $table_name=$table_prefix."contacts";
    
        $FirstName = $_POST['Name'];
        $LastName = $_POST['FamilyName'];
        $MobileNumber = $_POST['MobileNumber'];
        $HomeNumber = $_POST['HomeNumber'];
        $Email = $_POST['Email'];
        $Fax = $_POST['Fax'];
        $Birthday = $_POST['Birthday'];
        $Gender = $_POST['Gender'];
        $Category = $_POST['Category'];
    
        $wpdb->update($table_name,
                        array(
                            'FirstName'=>$FirstName,
                            'LastName'=>$LastName,
                            'MobileNumber'=>$MobileNumber,
                            'HomeNumber'=>$HomeNumber,
                            'Email'=>$Email,
                            'Fax'=>$Fax,
                            'Birthday'=>$Birthday,
                            'Gender'=>$Gender,
                            'Category'=>$Category
                        ),
                        array(
                            'Id' => $_GET['ID']
                        ),
                        array(
                            '%s', //use for string format
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '%s'
                        ),
                        array(
                            '%d'
                        )
        );
    }


function groups_content() {

?>

<!DOCTYPE html>
    <html>
        <head>
                <style>

                    table {
                        border-collapse: collapse;
                        width: 30%;
                    }

                    th, td {
                        padding: 8px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }

                    tr:hover {background-color: #ccccff;}

                    form.example button {
                        float: left;
                        width: 20%;
                        padding: 10px;
                        background: #2196F3;
                        color: white;
                        font-size: 17px;
                        border: 1px solid grey;
                        border-left: none;
                        cursor: pointer;
                    }

                </style>
        </head>

        <body>
            <h1>Groups</h1>
            <form method = "POST" action="<?php echo admin_url('admin.php?page=groups');?>">
    
                <table>
    
                            <thead>
                                <tr>
                                    <th><button name="delete_button">Delete</button></th>
                                    <td><button name="edit_button">Edit</button></td>
                                    <td>Group Name</td>
                                    <td>Members</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    global $wpdb,$table_prefix;
                                    $table_name=$table_prefix."groups";
                                    if(isset($_POST['delete_button']) AND isset($_POST['select'])){
                                        for($i=0; $i<count($_POST['select']); $i++ ){
                                            $select_Id = $_POST['select'][$i];
                                            $wpdb->delete($table_name,
                                                        array(
                                                            'Id' => $select_Id
                                                        )
                                            );
                                        }
                                    }

                                    if(isset($_POST['edit_button']) AND isset($_POST['select'])){
                                        ?>
                                            <meta http-equiv="Refresh" content="0; url='admin.php?page=edit_group&ID=<?php print($_POST['select'][0]); ?>'" />
                                        <?php
                                    }

    
                                    $result=$wpdb->get_results("SELECT * FROM $table_name ORDER BY `wp_groups`.`GroupName` ASC");
                                    
                                    foreach($result as $row){
                                        $Id = $row->Id;
                                ?>
                                        <tr>
                                            <td><input type = "checkbox" name = "select[]" value="<?php echo $Id; ?>"></td>
                                            <td></td>
                                            <th><?php echo $row->GroupName ?></th>
                                            
                                            <th>
                                                <?php
                                                $thisGroupMembers = (explode(',',$row->Members));
                                                foreach($thisGroupMembers as $thisMember){
                                                    $thisMember_data = $wpdb->get_results("SELECT FirstName, LastName FROM `wp_contacts` WHERE id='".$thisMember."'")[0];
                                                    print_r($thisMember_data->FirstName." ".$thisMember_data->LastName."<br>\n");
                                                }  
                                    }
                                                ?> 
                                            </th>
                                        </tr>
                            </tbody>
                </table>
            </form>
        </body>
    </html>
<?php
}


function create_group_content() {

        global $wpdb,$table_prefix;
        $table_name=$table_prefix."contacts";
    
    ?>
    
        <!DOCTYPE html>
            <html>
                <head>
                    <style>

                        table {
                            border-collapse: collapse;
                            width: 70%;
                        }

                        th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 1px solid #ddd;
                        }

                        tr:hover {background-color: #ccccff;}

                        form.example button {
                            float: left;
                            width: 20%;
                            padding: 10px;
                            background: #2196F3;
                            color: white;
                            font-size: 17px;
                            border: 1px solid grey;
                            border-left: none;
                            cursor: pointer;
                        }

                    </style>
                </head>

                <body>
                    <div> 
                            <h1>Create Group</h1>
            
                        <form name="group" method="POST">

                            <p>
                            <label for="Group Name">Group Name </label>
                            <input type="text" name="GroupName" id="GroupName" minlength="1" required>
                            </p>

                            <table>

                                <thead>
                                    <tr>
                                        <td>Select</td>
                                        <td>First Name</td>
                                        <td>Last Name</td>
                                        <td>Mobile Number</td>
                                        <td>Home Number</td>
                                        <td>Email</td>
                                        <td>Fax</td>
                                        <td>Birthday</td>
                                        <td>Gender</td>
                                        <td>Category</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $result=$wpdb->get_results("SELECT * FROM $table_name");
                                        foreach($result as $row){
                                            $Id = $row->Id;
                                    ?>
                                            <tr>

                                                <td><input type = "checkbox" name = "select[]" value="<?php echo $Id; ?>" checked></td>
                                                <th><?php echo $row->FirstName ?></th>
                                                <th><?php echo $row->LastName ?></th>
                                                <th><?php echo $row->MobileNumber ?></th>
                                                <th><?php echo $row->HomeNumber ?></th>
                                                <th><?php echo $row->Email ?></th>
                                                <th><?php echo $row->Fax ?></th>
                                                <th><?php echo $row->Birthday ?></th>
                                                <th><?php echo $row->Gender ?></th>
                                                <th><?php echo $row->Category ?></th>                                        

                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>

                            <p>&nbsp;</p>

                            <input type="submit" value="Submit" name="group_submit_button">

                        </form>
                    </div>
                </body>
            </html>  
    <?php

        if(isset($_POST["group_submit_button"])){
            global $wpdb,$table_prefix;
            $table_name=$table_prefix."groups";

            if(isset($_POST['select'])){
                $selected_list="";
                for($i=0; $i<count($_POST['select']); $i++ ){
                    if($i!=0){$selected_list=$selected_list.",";}
                    $select_Id = $_POST['select'][$i];
                    $selected_list=$selected_list.$select_Id;
                }
            }

            $GroupName = $_POST['GroupName'];

            $wpdb->insert($table_name,
                            array(
                                'GroupName'=>$GroupName,
                                'Members'=>$selected_list
                            ),
                            array(
                                '%s', //use for string format
                                '%s'
                            )
            );  
    
        }
    }

function edit_group_content() {

    if(!isset($_GET['ID'])){
        print("you can't use this page directly! :)");
        exit;
    }
    global $wpdb,$table_prefix;
    $table_name=$table_prefix."groups";

    $result=$wpdb->get_results("SELECT * FROM $table_name WHERE Id='".$_GET['ID']."'");
    foreach($result as $row){
        $Id = $row->Id;
        $Members = $row->Members;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <style>

            table {
                border-collapse: collapse;
                width: 70%;
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            tr:hover {background-color: #ccccff;}

            form.example button {
                float: left;
                width: 20%;
                padding: 10px;
                background: #2196F3;
                color: white;
                font-size: 17px;
                border: 1px solid grey;
                border-left: none;
                cursor: pointer;
            }

        </style>
    </head>

    <body>
        <div> 
                <h1>Edit Group</h1>
            <?php
                if(!isset($row->GroupName)){
                    ?>
                    could not find the Group you wanted! :(
                    <meta http-equiv="Refresh" content="5; url='admin.php?page=groups'" />
                    <?php
                    exit;

                }
                ?>

                    <form name="group" method="POST">

                        <p>
                            <label for="Group Name">Group Name </label>
                            <input type="text" name="GroupName" id="GroupName" value="<?php echo $row->GroupName ?>" minlength="1" required>
                        </p>

                        <table>

                            <thead>
                                <tr>
                                    <td>Select</td>
                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Mobile Number</td>
                                    <td>Home Number</td>
                                    <td>Email</td>
                                    <td>Fax</td>
                                    <td>Birthday</td>
                                    <td>Gender</td>
                                    <td>Category</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $data = $wpdb->get_results("SELECT * FROM $table_name WHERE Id='".$_GET['ID']."'");
                                    foreach($data as $thisMember){
                                        $thisGroupMembers = explode(",",$thisMember->Members);
                                    }

                                    $result=$wpdb->get_results("SELECT * FROM `wp_contacts`");

                                    foreach($result as $row){
                                        $Id = $row->Id;
                                            if(array_search($Id,$thisGroupMembers)!=""){
                                                $IsMember=1;
                                            }else{
                                                $IsMember=0;
                                            }
                                ?>
                                        <tr>
                                                <td>
                                                    <input type = "checkbox" name = "select[]" value="<?php echo $Id; ?>"

                                                    <?php
                                                    if($IsMember==1){
                                                        print("checked");
                                                    }
                                                    ?>
                                                    />
                                                </td>
                                                <th><?php echo $row->FirstName ?></th>
                                                <th><?php echo $row->LastName ?></th>
                                                <th><?php echo $row->MobileNumber ?></th>
                                                <th><?php echo $row->HomeNumber ?></th>
                                                <th><?php echo $row->Email ?></th>
                                                <th><?php echo $row->Fax ?></th>
                                                <th><?php echo $row->Birthday ?></th>
                                                <th><?php echo $row->Gender ?></th>
                                                <th><?php echo $row->Category ?></th>
                                        </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>

                        <p>&nbsp;</p>

                        <input type="submit" value="Submit" name="group_edit_button">

                    </form>
        </div>
    </body>
</html>

<?php
}

if(isset($_POST["group_edit_button"])){

    global $wpdb,$table_prefix;
    $table_name=$table_prefix."groups";

    if(isset($_POST['select'])){
        $selected_list="";
        for($i=0; $i<count($_POST['select']); $i++ ){
            if($i!=0){$selected_list=$selected_list.",";}
            $select_Id = $_POST['select'][$i];
            $selected_list=$selected_list.$select_Id;
        }
    }

    $GroupName = $_POST['GroupName'];
    

    $wpdb->update($table_name,
                    array(
                        'GroupName'=>$GroupName,
                        'Members'=>$selected_list
                    ),
                    array(
                        'Id' => $_GET['ID']
                    ),
                    array(
                        '%s', //use for string format
                        '%s'
                    ),
                    array(
                        '%d'
                    )
    );
}
?>