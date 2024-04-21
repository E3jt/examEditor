<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Edytor Egzaminów</title>
     <link rel="stylesheet" href="styling_viever.css">

     <style>
          textarea:read-only:hover{
               cursor: default;
          }
          textarea:focus{}
          textarea{}
     </style>

    <script>
        function handleRadio(element){            // funkcja odpowiedzialna za to by radio buttony o roznych nameach zachowywaly sie jak takie ktore maja takie same namey
            var parent = element.parentNode.parentNode.parentNode;
            var list = parent.querySelectorAll('.answerR');
            list.forEach(current => {
                current.checked = false;
                current.value = 0;
            });
            element.value = 1;
            element.checked = true;
        };
       
          function opener(a){
               window.open("http://localhost/exams/viever.php?id=" + a,"_self");   // funkcja otwierajaca strone z danym id przekazywanym przy pomocy $_GET
          };  
    </script>
</head>
<body>

     <div id="main">
            <form method="post" id="form">
                <button id="removeAll" style="background-color:green;" type="button">Prześlij egzamin</button>
                <div id="overlay">
                <remove>
                Jesteś pewien? Przesłanego egzaminu nie można edytować.
                <container><form method="post"><input type="submit" name="deleteAll" id="deleteA" value="Tak"></form><button id="no">Nie</button></container>
                <remove>
            </div>
            </form>
     </div>
     

     <?php

     function validateState($in){       //funkcja walidacyjna
          if(!$in) return(0);
          else return(1);
     };


     session_start();
        $Gid = $_GET['id'];
        @$userId = $_SESSION['stid'];
        $connectAnswers = mysqli_connect('localhost','root','','answers');
        $completion = mysqli_query($connectAnswers , "SELECT * FROM `completed` WHERE `userID` = $userId AND `examId` = $Gid");
        $completion = mysqli_fetch_row($completion);

        if(@$completion[0]){            // jezeli egzamin zostal wczesniej uzupelniony to przenosimy na strone wyswietlajaca odpowiedzi
            print("<script>opener($Gid);</script>");        
        };
          if (@$_SESSION['state'] == "true" && @$_SESSION['type'] == "student"){
               $examsConnect = mysqli_connect('localhost','root','','exams');
               $utf = mysqli_query($examsConnect,"SET CHARACTER SET utf8");
               $exam = mysqli_query($examsConnect, "SELECT * FROM `$Gid` ORDER BY id");        //pobieranie egzaminu
               $exam = mysqli_fetch_all($exam);

               if(!$exam){
                    print("Nie ma nic  w sprawdzianie");
               }else{
                    print("<script>var gCounter =". $exam[0][0].";</script>");       //ustawianie globalnego id pytan na to ktore zostalo pobrane z bazy danych
                    foreach($exam as $question){
                         if($question[2] == 1){                  // budowanie formularza
                              print('<script>
                                        var questionCounter = gCounter;  var sCounter = 0;

                                        var form = document.createElement("div");    
                                        var question = document.createElement("textarea");  
                                        var ref = document.getElementById("removeAll"); 
                                        var grid = document.createElement("div");
                                        grid.className = "operational";

                                        question.name = "question["+ questionCounter +"]";
                                        question.style = "resize : none;";
                                        question.value = "'.$question[3].'";
                                        question.className = "question";
                                        question.setAttribute("readOnly", "");
                                        
                                        form.className = "que";
                                        

                                        grid.appendChild(question);
                                        form.appendChild(grid);

                                        document.getElementById("form").insertBefore(form , ref);
                                        gCounter += 1;

                                   </script>
                              ');
                              foreach($exam as $current){
                                   if(($current[0] == $question[0]) and ($current[2] == 2)){
                                        print('
                                             <script>

                                                  sCounter += 1;
                                                  var radio = document.createElement("input"), label = document.createElement("label"), answer = document.createElement("textarea");
                                                  var parent = document.createElement("div");
                                                  
                                                  radio.type = "radio";      
                                                  radio.name = "answerCorrect["+ questionCounter +"]["+sCounter+"]";
                                                  radio.className = "answerR";


                                                  answer.placeholder = "Podaj odpowiedź";      
                                                  answer.name = "answerContent["+ questionCounter +"]["+sCounter+"]";       
                                                  answer.style = "resize : none;";
                                                  answer.value = "'.$current[3].'";
                                                  answer.className = "answer";
                                                  answer.setAttribute("readOnly", "");


                                                  label.htmlFor = "answerContent["+ questionCounter +"]["+sCounter+"]";      
                                                  label.className = "answerCorrect["+ questionCounter +"]["+sCounter+"]";
                                             

                                                  label.appendChild(radio);     parent.appendChild(answer);     parent.appendChild(label);      form.appendChild(parent);

                                             </script>
                                        ');
                                   };
                              };
                         }else if($question[2] == 3){
                              foreach($exam as $current){
                                   if(($current[0] == $question[0]) and ($current[2] == 2)){
                                        print('
                                        <script>

                                            var questionCounter = gCounter;
                                            var answer = document.createElement("textarea");
                                            var form = document.createElement("div");
                                            var question = document.createElement("textarea");  
                                            var ref = document.getElementById("removeAll");

                                            question.placeholder = "Treść pytania";
                                            question.name = "questionC["+ questionCounter +"]";
                                            question.style = "resize : none;";
                                            question.value = "'.$question[3].'";
                                            question.className = "question";
                                            question.setAttribute("readOnly", "");  


                                            answer.name = "answerContentC["+ questionCounter +"][1]";
                                            answer.style = "resize : none;";
                                            answer.className = "answer";
                                            answer.placeholder = "Podaj odpowiedź";   


                                            form.className = "queC";
                                            
                                            form.appendChild(question);
                                            form.appendChild(answer);
                                            
                                            document.getElementById("form").insertBefore(form , ref);
                                            gCounter += 1;
                                             
                                        </script>
                                        ');
                                   };
                              };
                         };
                    };
               };
          
            if(@$_POST['deleteAll']){                  // funkcja zapisujaca pod nazwa deleteall poniewaz jestem leniwy
                $input = "INSERT INTO `$Gid` (`userid`, `questionID`, `answerID`, `type`, `content` ) VALUES ";
                if(@$_POST['answerContent']){
                    foreach(@$_POST['answerCorrect'] as $id => $value){
                        foreach(@$value as $Cid => $current){
                            @$input .= '('.$userId.','.$id.','.$Cid.', 0 , "") ,';
                    };
                };
                
                if(@$_POST['questionC']){
                    foreach(@$_POST['questionC'] as $id => $value){
                        foreach(@$_POST["answerContentC"][$id] as $Cid => $current){
                                $input .= '('.$userId.','.$id.','.$Cid.', 1 , "'.$current.'") ,';
                            };
                        };
                    };
                };
                $input = substr($input, 0, -1);
                print($input);     
                $in = mysqli_query($connectAnswers, $input);
                $completion = mysqli_query($connectAnswers, "INSERT INTO `completed` (`userID`, `examId`) VALUES ('$userId', '$Gid')");          //wczytywanie oraz przenoszenie na strone glowna
                print('<script>window.open("http://localhost/exams/mainStudent.php", "_self");</script>');
            };
               
          };


          mysqli_close($examsConnect);
          mysqli_close($connectAnswers);


     ?>

    <script>
               document.querySelectorAll('.answerR').forEach(element => {
                    element.setAttribute("onclick","handleRadio(this);");
               });

               document.getElementById("removeAll").addEventListener("click", () => {
                    document.getElementById("overlay").style = "display:block;";
                    document.getElementById("removeAll").disabled = true;
               });

               document.getElementById("no").addEventListener("click", () => {
                    document.getElementById("overlay").style = "display:none;";
                    document.getElementById("removeAll").disabled = false;
               });
    </script>


</body>
</html>