<?php
include '../login/login.php' ; // Includes Login Script

if(isset($_SESSION['login_user'])){
    if($_SESSION['user_type']=='user'){
      header("location: ../login");     
    } 
}
else {
  header("location: ../login");
}
require_once('../databaseFunction/DatabaseFunctions.php');
 
$users;
$db = new Database("127.0.0.1",$DBUserName,$DBPassword, "cafedb");
$users=$db->getAllUsers();

function getUsers()
{
    global $users;
    require '../configrationfile.php';
    $db = new Database("127.0.0.1", $DBUserName,$DBPassword, "cafedb");
    $users = $db->getAllUsers();
    renderUsers($users);
}

function renderUsers($users)
{
    echo '<table id="data" >
        <tr>
            <th>Name</th>
            <th>Image</th> 
            <th>Action</th>
        </tr>';


    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>'.$user['user_name'].'</td>'; 
        if(empty($user['profile_pic'])!==true)
        echo "<td> <img class=\"pic\" src= \"../imag/".$user['profile_pic']."\"/> </td>";
        else  echo "<td> <img class=\"pic\" src= \"../imag/download.png\"/> </td>";
        echo "<td> <a href=\"edituser.php?id=".$user['user_id']."\"><button class='button updatebtn'> Update </button></a>";
        echo "<a href=\"deleteuser.php?id=".$user['user_id']."\"><button class='button deletebtn'> Delete  </button></a> </td>"; 
        echo '</tr>';
    }
    
    echo '</table>';    
}


?>

<!DOCTYPE Html>
<html>

<?php  include "../adminHeader.php";?>

<div class="main">
    <section>
        <h1 class="pageTitle"> All Users </h1>
        <table>
            <tr>
                <td width=100></td>
                <td> 
                    <a href="adduser.php" >
                        <button class='button updatebtn'>Add New User </button>
                    </a>
                </td>
            </tr>
        </table>
        <br>
    </section>
    
    <section class="content" >
     <?php  getUsers(); ?> 

    </section>
    </div>
    <!-- If something went wrong-->
    <h2>
    <?php
        if(isset($_GET['error']) && $_GET['error'] == 1){
            echo "Something went wrong";
        }else if (isset($_GET['error']) && $_GET['error'] == 'duplicate'){
            echo "duplicate entry please check data entered";
        }
    ?>
    </h2>
    </div>
</body>
</html>




