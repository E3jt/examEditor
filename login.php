<html>

    <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="assets/web/stylesheet.css" type="text/css" charset="utf-8"/>
    <link rel="stylesheet" href="styling_credentials.css">
    </head>

    <body>

    <form method="post">
        <p id="title">Login</p>
        <input type="text" name="login" placeholder="Login">
        <div class="alert_l">This login does not exist!</div>
        <input type="password" name="pas" placeholder="Password">
        <div class="alert_p">Wrong password or login!</div>
        <input type="submit" value="Send" name="add" id="sub">
        <span>
            <a href="main.php">Strona główna</a>    |
            <a href="studentLogin.php">Logowanie ucznia</a>
        </span>
    </form>

    <div id="registerd">
        Registered successfully. You are now able to log in.
    </div>




    <script>

        function login(){
            document.getElementsByTagName("input")[0].style.borderRight = "0.2em red solid";
            document.getElementsByTagName("div")[0].style.display = "block";
        };

        function password(){
            document.getElementsByTagName("input")[1].style.borderRight = "0.2em red solid";
            document.getElementsByTagName("div")[1].style.display = "block";
        };

        function registerd(){
            document.getElementsByTagName('div')[2].style.display = "block";

        };
	</script>


    <?php


        session_start();
        if(@$_SESSION['registerd'] == "true"){      // Ten kawałek kodu ODPOWIADAŁ za potwierdzenie rejstracji
            print"<script>registerd();</script>";
            $_SESSION['registerd'] = "false";
        };


        if (@$_POST['add']){
            @$login = $_POST['login'];      // Pobranie loginu oraz hasła
            @$pas = $_POST['pas'];

            $connect = mysqli_connect('localhost','root','','maindata');
            $utf = mysqli_query($connect,"SET CHARACTER SET utf8");

            $check_login = mysqli_query($connect,"SELECT `login`,`password` FROM `credentials` WHERE `login` =  '$login'");     // Wyszukiwanie danych odpowiadającyh tym podanym pzez użytkownika
            $fetch = mysqli_fetch_row($check_login);
            @$fetch_l = $fetch[0];
            @$fetch_p = $fetch[1];
                                if(!$fetch_l){
                                    echo'<script>login();</script>';                // Błąd z brakiem loginu w bazie danych
                                    mysqli_close($connect);
                                    die;
                                }else{
                                    if(($pas != null AND ($pas == $fetch_p)) AND ($login != null AND ($login == $fetch_l))){
                                        $getid = mysqli_query($connect,"SELECT `id` FROM `credentials` WHERE `login` =  '$login'");
                                        $id = mysqli_fetch_row($getid);
                                        $_SESSION['id'] = $id[0];                   // ustawianie sesji mówiących o typie użytkownika oraz jego id
                                        $_SESSION['state'] = "true";
                                        $_SESSION['type'] = "teacher";
                                        header("location:main.php");
                                    }
                                    else if($pas != $fetch_p){
                                        echo'<script>password();</script>';         // Błędne hasło
                                        mysqli_close($connect);
                                        die;
                                    };
                                    mysqli_close($connect);
                                };
        };

?>



    </body>

</html>