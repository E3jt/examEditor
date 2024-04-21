<html>

    <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="assets/web/stylesheet.css" type="text/css" charset="utf-8"/>
    <link rel="stylesheet" href="styling_credentials.css">
    </head>

    <body>

    <form method="post">
        <p id="title">Register</p>
        <input type="text" name="login" placeholder="Login">
        <div class="alert_l">Login already exists!</div>
        <input type="password" name="pas" placeholder="Password">
        <div class="alert_p">Passsowrds don't match!</div>
        <input type="password" name="pas1" placeholder="Repeat password">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="surname" placeholder="Surname">
        <input type="submit" value="Send" name="add" id="sub">
        <span>
            <a href="main.php">Main site</a>   |
            <a href="login.php">Login</a>
        </span>
    </form>




    <script>

        function login(){
            document.getElementsByTagName("input")[0].style.borderRight = "0.2em red solid";
            document.getElementsByTagName("div")[0].style.display = "block";
        };

        function password(){
            document.getElementsByTagName("input")[1].style.borderRight = "0.2em red solid";
            document.getElementsByTagName("div")[1].style.display = "block";
        };
	</script>


    <?php


        if($_POST['add']){
            @$login = $_POST['login'];
            @$pas = $_POST['pas'];
            @$pas1 = $_POST['pas1'];
            @$name = $_POST['name'];
            @$surname = $_POST['surname'];

            $connect = mysqli_connect('localhost','root','','maindata');
            $utf = mysqli_query($connect,"SET CHARACTER SET utf8");

            $checking = mysqli_query($connect,"SELECT `login` FROM `credentials` WHERE `login` =  '$login'");
            $fetch = mysqli_fetch_all($checking);
                                if($fetch or !$login){
                                    echo'<script>login();</script>';
                                    mysqli_close($connect);
                                    die;
                                }else{
                                    if($pas AND ($pas == $pas1)){
                                        $creds = mysqli_query($connect, "INSERT INTO `credentials` (`ID`, `login`, `password`, `name`, `surname`, `permissionLevel`) VALUES (NULL, '$login', '$pas', '$name', '$surname', '')");
                                        session_start();
                                        $_SESSION['registerd'] = "true";
                                        header("location:login.php");
                                    }
                                    else{
                                        echo'<script>password();</script>';
                                        mysqli_close($connect);
                                        die;
                                    };
                                    mysqli_close($connect);
                                };
        };

?>



    </body>

</html>