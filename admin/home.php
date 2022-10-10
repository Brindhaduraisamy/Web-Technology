
<?php
include '../login/login.php'; // Includes Login Script

if (isset($_SESSION['login_user'])) {
    if ($_SESSION['user_type'] == 'user') {
        header("location: ../login");
    }
}
else {
    header("location: ../login");
}


?>

<!DOCTYPE Html>
<html>

<?php include "../adminHeader.php"; ?>

<div class="main">
    <section>
        <h1 class="pageTitle"> Welcome Admin </h1>
        <!-- <button class="addLink">add product ?</button>   -->
        <br>
    </section>

    <section>

        <table>
            <tr> 
                 <td width=100></td>       
                <td height="256" width="200">
                    <a href="allproducts.php">
                        <img src="../imag/addcoffee.png" height="256" width="200" >
                    </a>
                    &nbsp 
                </td>
                <td width=50>

                </td>
                <td height="256" width="200">
                    <a href="showusers.php">
                        <img src="../imag/employees.png" height="256" width="200"  >
                    </a>
                    &nbsp 
                </td> 
            </tr>
            <tr>
                <td width=100></td>
                <td align=center >
                    <p> <h2> PRODUCTS </h2> </p>
                </td>
                <td width=50></td>
                <td align=center >
                    <p> <h2> PEOPLE </h2> </p>
                </td> 
            </tr>
                
            
        </table>
     
    </section>

</div>
<script src="js/adminHome.js"></script>
</body>
</html>