<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Edytor Egzaminów</title>
     <link rel="stylesheet" href="styling_viever.css">
     <style>
        input[type='radio']:hover{
            cursor: default;
            border: none;
        }
        textarea:hover{
            cursor: default;
        }
        #back{
          position: fixed;
          top: 2vh;
          left: 2vw;
          background-color: lightcoral;
          padding: 1em;
          font-size: 200%;
          text-decoration: none;
        }
    </style>
</head>
<body>
     
<a href="mainStudent.php" id="back">Strona główna</a>
     <div id="main">
            <form method="post" id="form">
            </form>
     </div>
     

     <?php

     function validateState($in){
          if(!$in) return(0);
          else return(1);
     };


     session_start();
        $Gid = $_GET['id'];
        @$userId = $_SESSION['stid'];
        $connectAnswers = mysqli_connect('localhost','root','','answers');
        $completion = mysqli_query($connectAnswers , "SELECT * FROM `completed` WHERE `userID` = $userId AND `examId` = $Gid");
        $completion = mysqli_fetch_row($completion);

          if (@$completion[0] && @$_SESSION['state'] == "true" && @$_SESSION['type'] == "student" || (@$_SESSION['type'] = "teacher")){     // sprawdzanie dostepu do egzaminu
               
            
                $examsConnect = mysqli_connect('localhost','root','','exams');
               $utf = mysqli_query($examsConnect,"SET CHARACTER SET utf8");
               $exam = mysqli_query($examsConnect, "SELECT * FROM `$Gid` ORDER BY id");
               $exam = mysqli_fetch_all($exam);
               $correct = mysqli_query($examsConnect, "SELECT `id`,`answerId`,`correct` FROM `$Gid` WHERE `correct` = 1");
               $correct = mysqli_fetch_all($correct);

               if(!$exam){
                    print("Nie ma nic  w sprawdzianie");
               }else{
                    print("<script>var gCounter =". $exam[0][0].";</script>");
                    foreach($exam as $question){
                         if($question[2] == 1){        // tworzenie formularza - pytanie zamkniete
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
                                   if(($current[0] == $question[0]) and ($current[2] == 2)){        // tworzenie formularza - odpowiedz na pytanie zamkniete
                                        print('   
                                             <script>

                                                  sCounter += 1;
                                                  var radio = document.createElement("input"), label = document.createElement("label"), answer = document.createElement("textarea");
                                                  var parent = document.createElement("div");
                                                  
                                                  radio.type = "radio";      
                                                  radio.name = "answerCorrect["+ questionCounter +"]["+sCounter+"]";
                                                  radio.className = "answerR";
                                                  radio.disabled = true;


                                                  answer.placeholder = "Brak odpowiedzi";      
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
                              foreach($exam as $current){        // tworzenie formularza - pytanie otwarte
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
                                            answer.placeholder = "Brak odpowiedzi";   
                                            answer.setAttribute("readOnly", "");



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
               $handleAnswers = mysqli_query($connectAnswers , "SELECT `questionID`,`answerID`,`type`,`content` FROM `$Gid` WHERE `userid` = 1");
               $fetchAnswers = mysqli_fetch_all($handleAnswers);
               $correct = mysqli_query($examsConnect, "SELECT `id`,`answerId`,`correct` FROM `$Gid` WHERE `correct` = 1");
               $correct = mysqli_fetch_all($correct);
               print("<script>");
               foreach($fetchAnswers as $current){               //zaznaczenie wszystkich odpowiedzi uzytkownika na czerwono - zle lub pomaranczowo otwarte
                if($current[2] == 0){
                    print("document.getElementsByName('answerCorrect[".$current[0]."][".$current[1]."]')[0].style.backgroundColor = 'rgba(220, 20, 60, 0.536)';");
                    print("document.getElementsByName('answerContent[".$current[0]."][".$current[1]."]')[0].style.backgroundColor = 'rgba(220, 20, 60, 0.536)';");
                }elseif($current[2] == 1){
                    print("document.getElementsByName('answerContentC[".$current[0]."][".$current[1]."]')[0].style.backgroundColor = 'rgba(209, 100, 11, 0.6)';");
                    print("document.getElementsByName('answerContentC[".$current[0]."][".$current[1]."]')[0].value = '$current[3]';");
                };
                };
               foreach($correct as $current){               //zaznaczenie wszystkich poprawnych odpowiedzi wedlug klucza - na zielono
                    print("document.getElementsByName('answerCorrect[".$current[0]."][".$current[1]."]')[0].checked = true;");
                    print("document.getElementsByName('answerCorrect[".$current[0]."][".$current[1]."]')[0].style.backgroundColor = 'rgba(0, 100, 0, 0.664)';");
                    print("document.getElementsByName('answerContent[".$current[0]."][".$current[1]."]')[0].style.backgroundColor = 'rgba(0, 100, 0, 0.664)';");
               };
               print("</script>");

               
          };


          mysqli_close($examsConnect);
          mysqli_close($connectAnswers);


     ?>



</body>
</html>