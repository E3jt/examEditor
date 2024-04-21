<html>

    <head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="styling_General.css" type="text/css">
    <link rel="stylesheet" href="styling_main.css" type="text/css"/>



    </head>

    <body>

        <form method="post">
            <input type="text" placeholder="Nazwa egzaminu" name="examName"></input>
            <input type="text" placeholder="Opis egzaminu" name="description"></input>
            <input type="submit" name="send" value="Utwórz"></input>
        </form>

        <?php

        session_start();


        if (@$_SESSION['state'] == "true" && @$_SESSION['type'] == "teacher"){ // Sprawdzanie czy sesja jest nauczyciela i czy wogole jest
            $userId = $_SESSION['id'];
            $connect = mysqli_connect('localhost','root','','maindata');
            $utf = mysqli_query($connect,"SET CHARACTER SET utf8");
            $get_credentials = mysqli_query($connect,"SELECT `login`,`name`,`surname` FROM credentials WHERE `id` = '$userId'"); // pobieranie danych uzytkownika
            $fetch_login = mysqli_fetch_row($get_credentials);
            $login = "$fetch_login[0]($fetch_login[1] $fetch_login[2])"; // zapisywanie pobranych danych w sposob przystepny 
            mysqli_close($connect);

            if(@$_POST['send'] && $_POST['examName']){
                $examName = $_POST['examName'];
                $description = $_POST['description'];
                $id = $_SESSION['id'];
                $connect = mysqli_connect('localhost','root','','maindata');
                $connectExams = mysqli_connect('localhost','root','','exams');
                $connectAnswers = mysqli_connect('localhost','root','','answers');
                $utf = mysqli_query($connect,"SET CHARACTER SET utf8");
                $utf = mysqli_query($connectExams,"SET CHARACTER SET utf8");
                $insertExam = mysqli_query($connect,"INSERT INTO `examsinformation` (`ownerId`, `examId`, `examName`, `description`, `requiredPermissionLevel`) VALUES ('$id', 'NULL', '$examName', '$description', 2)");    //tworzenie instancji egzaminu w tabeli
                $get_latestId = mysqli_query($connect, "SELECT `examId` FROM `examsinformation` where `ownerId` = $id ORDER BY `examId` DESC"); // pobieranie najnowszego id potrzebnego do utworzenia tabeli egzaminu
                $exId = mysqli_fetch_row($get_latestId);
                $exId = $exId[0];
                $create_exam = mysqli_query($connectExams,"CREATE TABLE `$exId` ( 
                                            `id` int(11) NOT NULL,
                                            `answerId` int(11) NOT NULL,
                                            `type` tinyint(4) NOT NULL,
                                            `text` varchar(512) NOT NULL,
                                            `correct` tinyint(1) NOT NULL,
                                            `resource` varchar(1024) NOT NULL
                                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;
                                        ");  // tworzenie egzaminu jako tabeli
                                        
                $create_answer = mysqli_query($connectAnswers,"CREATE TABLE `answers`.`$exId` 
                (`userid` int(11) NOT NULL,
                `questionID` int(11) NOT NULL,
                `answerID` int(11) NOT NULL,
                `type` int(1) NOT NULL,
                `content` varchar(2048) NOT NULL ) 
                ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;");  // tworzenie tabeli egzaminu z odpowiedziami uzytkownikow
                mysqli_close($connect);
                mysqli_close($connectExams);
                header("location:main.php"); // odswiezenie(przejscie z powrotem na stone na ktorej sie znajdujemy)
            };
        }else{
            $login = "You are not logged in."; // pyrzpadek w ktorym nie jestesmy zalogowani lub status naszego loginu nie jest nauczycielski
        };
        print("<p>Witaj ".$login."!</p>");

        $connect = mysqli_connect('localhost','root','','maindata');
        $utf = mysqli_query($connect,"SET CHARACTER SET utf8");
        @$get_exams = mysqli_query($connect,"SELECT `examName`,`description`,`examId` FROM `examsinformation` WHERE `ownerId` = '$userId'"); // pobieranie informacji na temat egzaminow
        $examsList = mysqli_fetch_all($get_exams);
        $_SESSION['input'] = 0;
        foreach($examsList as $exam){
            print "<div><name>Nazwa : ".$exam[0]."</name> <description>Opis : ".$exam[1]."</description><button class='opener' onclick='opener($exam[2])'>Edycja egzaminu</button></div>";
        }; // /\/\/\/\ wypisywanie informacji na temat egzaminow
        mysqli_close($connect);
        ?>


                
        <script>
            function opener(a){
                window.open("http://localhost/exams/examEditor.php?id=" + a,"_self");   
            };  
        </script>

    </body>
</html>