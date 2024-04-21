<html>

    <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="styling_General.css">
    <link rel="stylesheet" href="styling_main.css" type="text/css"/>
    </head>

    <body>

        <?php

        session_start();


        if (@$_SESSION['state'] == "true" && @$_SESSION['type'] == "student"){          //sprawdzanie typu sesji
            $userId = $_SESSION['stid'];
            $connect = mysqli_connect('localhost','root','','maindata');
            $utf = mysqli_query($connect,"SET CHARACTER SET utf8");
            $get_credentials = mysqli_query($connect,"SELECT `login`,`name`,`surname` FROM studentscredentials WHERE `id` = '$userId'");            // pobieranie danych uzytkownika
            $fetch_login = mysqli_fetch_row($get_credentials);
            $login = $fetch_login[0] ." (". $fetch_login[1] . " ".$fetch_login[2]. ")";
            mysqli_close($connect);

        }else{
            $login = "You are not logged in.";
        }
        print("<p>Witaj ".$login."!</p>");

        $connect = mysqli_connect('localhost','root','','maindata');
        $utf = mysqli_query($connect,"SET CHARACTER SET utf8");
        @$get_exams = mysqli_query($connect,"SELECT `examName`,`description`,`examId` FROM `examsinformation`");            //pobieranie egzaminow z bazy danych
        $examsList = mysqli_fetch_all($get_exams);
        foreach($examsList as $exam){
            print "<div><name>Nazwa : ".$exam[0]."</name> <description>Opis : ".$exam[1]."</description><button class='opener' onclick='opener($exam[2])'>Edycja egzaminu</button></div>";
        };
        mysqli_close($connect);
        ?>


                
        <script>
            function opener(a){
                window.open("http://localhost/exams/exam.php?id=" + a,"_self");   
            };  
        </script>

    </body>
</html>