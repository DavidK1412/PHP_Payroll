<?php
    if(isset($_COOKIE['access_data'])){
        // Go to the login page
        header('Location: ../app/views/admin.php?view=payroll');
    }else{
        header('Location: ../app/views/login.php');
    }
?>