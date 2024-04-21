<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Edytor Egzaminów</title>
     <link rel="stylesheet" href="styling_General.css">
     <script>
          function remove(el) {                        // funkcja usuwajaca elementy
               var element = el;
               element.innerHTML = "";
               element.remove();
          };
          function adder(el) {            // dynamiczne dodawanie elementow sluzace do tworzenia odpowiedzi na pytania
                    sCounter += 1;
                    var element = el;
                    var radio = document.createElement("input"), label = document.createElement("label"), answer = document.createElement("textarea");
                    var parent = document.createElement("div"), answerDeleter = document.createElement("button");

                    radio.type = "checkbox";      
                    radio.name = "answerCorrect["+ questionCounter +"]["+sCounter+"]";    
                    radio.value = false;
               
               
                    answerDeleter.type = "button";
                    answerDeleter.className = "garbageCan";
                    answerDeleter.setAttribute("onclick","remove(this.parentNode);");
               
               
                    answer.placeholder = "Podaj odpowiedź";      
                    answer.name = "answerContent["+ questionCounter +"]["+sCounter+"]";       
                    answer.style = "resize : none;";
               
               
                    label.htmlFor = "answerContent["+ questionCounter +"]["+sCounter+"]";      
                    label.className = "answerCorrect["+ questionCounter +"]["+sCounter+"]";
                                       
               
                    label.appendChild(radio);     parent.appendChild(answer);     parent.appendChild(label);       parent.appendChild(answerDeleter);      element.appendChild(parent);
                    
               };
     </script>
</head>
<body>
     
     <div id="overlay">
          <remove>
          Jesteś pewien? Usunięcie egzaminu jest nie odwracalne.
          <container><form method="post"><input type="submit" name="deleteAll" id="deleteA" value="Tak"></form><button id="no">Nie</button></container>
          <remvoe>
     </div>

     <div id="main">
          <form method="post" id="form">
               <input type="submit" name="check" id="check"/>
               </form>
               <button id="closed">Dodaj pytanie zamkniete</button>
               <button id="opened">Dodaj pytanie otwarte</button>
               <button id="removeAll">Usuń egzamin</button>
     </div>
     

     <?php

     function validateState($in){                           // walidacja wartosci pobranbej z checkboxa
          if(!$in) return(0);
          else return(1);
     };


     session_start();
          $Gid = $_GET['id'];
          @$userId = $_SESSION['id'];
          $mainConnect = mysqli_connect('localhost','root','','maindata');
          $utf = mysqli_query($mainConnect,"SET CHARACTER SET utf8");
          $ownership = mysqli_query($mainConnect, "SELECT ownerId FROM examsinformation WHERE examId = $Gid");
          $ownershipId = mysqli_fetch_all($ownership);
          if (@$_SESSION['state'] == "true" && @$_SESSION['type'] == "teacher" && $ownershipId[0][0] == $userId){       // sprawdzanie sesji oraz czy osoba posiada dostep do egzaminu
               $connectAnswers = mysqli_connect('localhost','root','','answers');
               $examsConnect = mysqli_connect('localhost','root','','exams');
               $utf = mysqli_query($examsConnect,"SET CHARACTER SET utf8");
               $exam = mysqli_query($examsConnect, "SELECT * FROM `$Gid` ORDER BY id");                                 // pobieranie calego egzaminu
               $exam = mysqli_fetch_all($exam);
               $correct = mysqli_query($examsConnect, "SELECT `id`,`answerId`,`correct` FROM `$Gid` WHERE `correct` = 1");   // pobieranie porwanych odpowiedzi
               $correct = mysqli_fetch_all($correct);

               if(!$exam){
                    print("<script>var gCounter = 1 ;</script>");               // jezeli egzamin nie istnieje ustawienie poczatkowej wartosci globalnego licznika na 1
               }else{
                    print("<script>var gCounter =". $exam[0][0].";</script>");
                    foreach($exam as $question){
                         if($question[2] == 1){                                 // jesli typ pobranej danej wynosi 1 tworzenie pytania
                              print('<script>

                                   var questionCounter = gCounter;  var sCounter = 0;

                                   var form = document.createElement("div");    
                                   var formDeleter = document.createElement("button");    
                                   var answerAdder = document.createElement("button");    
                                   var question = document.createElement("textarea");  
                                   var ref = document.getElementById("check"); 
                                   var grid = document.createElement("div");
                                   grid.className = "operational";

                                   
                                   
                                   formDeleter.setAttribute("onclick","remove(this.parentNode.parentNode);");

                                   question.placeholder = "Treść pytania";
                                   question.name = "question["+ questionCounter +"]";
                                   question.style = "resize : none;";
                                   question.value = "'.$question[3].'";
                                   question.className = "question";
                                   
                                   answerAdder.type = "button";
                                   answerAdder.className = "adder";
                                   answerAdder.innerHTML = "Dodaj odpowiedź";


                                   formDeleter.type = "button";
                                   formDeleter.className = "remove";
                                   formDeleter.innerHTML = "Usuń pytanie";

                                   
                                   form.className = "que";
                                   

                                   grid.appendChild(question);
                                   grid.appendChild(answerAdder);
                                   grid.appendChild(formDeleter);
                                   form.appendChild(grid);

                                   document.getElementById("form").insertBefore(form , ref);
                                   answerAdder.setAttribute("onclick","adder(this.parentNode.parentNode);");
                                   gCounter += 1;
                                   

                                   </script>
                              ');
                              foreach($exam as $current){
                                   if(($current[0] == $question[0]) and ($current[2] == 2)){             // jezeli typ wynosi 2 oraz id odpowiedzi jest rowne id pytania to tworzenie odpowiedzi
                                        print('
                                             <script>
                                                  sCounter += 1;
                                                  var radio = document.createElement("input"), label = document.createElement("label"), answer = document.createElement("textarea");
                                                  var parent = document.createElement("div"), answerDeleter = document.createElement("button");
                                                  
                                                  radio.type = "checkbox";      
                                                  radio.name = "answerCorrect["+ questionCounter +"]["+sCounter+"]";


                                                  answerDeleter.type = "button";
                                                  answerDeleter.className = "garbageCan";
                                                  answerDeleter.setAttribute("onclick","remove(this.parentNode);");


                                                  answer.placeholder = "Podaj odpowiedź";      
                                                  answer.name = "answerContent["+ questionCounter +"]["+sCounter+"]";       
                                                  answer.style = "resize : none;";
                                                  answer.value = "'.$current[3].'";
                                                  answer.className = "answer";


                                                  label.htmlFor = "answerContent["+ questionCounter +"]["+sCounter+"]";      
                                                  label.className = "answerCorrect["+ questionCounter +"]["+sCounter+"]";
                                             

                                                  label.appendChild(radio);     parent.appendChild(answer);     parent.appendChild(label);       parent.appendChild(answerDeleter);      form.appendChild(parent);


                                             </script>
                                        ');
                                   };
                              };
                         }else if($question[2] == 3){
                              foreach($exam as $current){
                                   if(($current[0] == $question[0]) and ($current[2] == 2)){             // to samo co u góry tylko pytanie i odpowiedź do otwartego
                                        print('
                                        <script>

                                             var questionCounter = gCounter;
                                             var answer = document.createElement("textarea");
                                             var form = document.createElement("div");
                                             var formDeleter = document.createElement("button");
                                             var question = document.createElement("textarea");  
                                             var ref = document.getElementById("check");

                                             formDeleter.setAttribute("onclick","remove(this.parentNode);");

                                             question.placeholder = "Treść pytania";
                                             question.name = "questionC["+ questionCounter +"]";
                                             question.style = "resize : none;";
                                             question.value = "'.$question[3].'";
                                             question.className = "question";


                                             answer.name = "answerContent["+ questionCounter +"][1]";
                                             answer.style = "resize : none;";
                                             answer.value = "'.$current[3].'";
                                             answer.className = "answer";
                                             answer.placeholder = "Podaj odpowiedź";      



                                             formDeleter.type = "button";
                                             formDeleter.className = "remove";
                                             formDeleter.innerHTML = "Usuń pytanie";


                                             form.className = "queC";
                                             
                                             form.appendChild(question);
                                             form.appendChild(answer);
                                             form.appendChild(formDeleter);
                                             
                                             document.getElementById("form").insertBefore(form , ref);
                                             gCounter += 1;
                                             
                                        </script>
                                        ');
                                   };
                              };
                         };
                    };
               };
               print("<script>");
               foreach($correct as $current){                         // ustawianie wszyswtkich poprawnych odpowiedzi na zaznaczone
                    print("document.getElementsByName('answerCorrect[".$current[0]."][".$current[1]."]')[0].checked = true;");
               };
               print("</script>");
               $input = "";
          
          if(@$_POST['deleteAll']){                                   // calkowite usuniecie tabel egzaminu oraz jego instancji w tabeli z informacjami
               $drop = mysqli_query($examsConnect, "DROP TABLE `exams`.`$Gid`");
               $deleteInstance = mysqli_query($mainConnect , "DELETE FROM examsinformation WHERE `examsinformation`.`examId` = ".$Gid);
               $deleteInstance = mysqli_query($connectAnswers , "DROP TABLE `answers`.`$Gid`");
               $deleteInstance = mysqli_query($connectAnswers, "DELETE FROM completed WHERE `examId` = $Gid");
               print('<script>window.open("http://localhost/exams/main.php", "_self");</script>');
          };


          if(@$_POST['check']){                   // budowanie kwerendy zapisujacej egzamin
               if(@$_POST['question'] || @$_POST['questionC']){$input = "INSERT INTO `$Gid` (`id`, `answerId`, `type`, `text`, `correct`, `resource`) VALUES ";}
               else{$truncateN = mysqli_query($examsConnect, "TRUNCATE TABLE `exams`.`$Gid`");};
               if(@$_POST['question']){
                    foreach(@$_POST['question'] as $id => $value){              //wczytywanie pytan
                         $input .='('.$id.', 0, 1, "'.$value.'", 0, "") ,';
                    };};
          if(@$_POST['answerContent']){
               foreach(@$_POST['answerContent'] as $id => $value){
                    foreach($value as $Cid => $current){
                         @$input .= '('.$id.','.$Cid.',2,"'.$current.'",'.validateState($_POST['answerCorrect'][$id][$Cid]).',"") ,';       // wczytywanie odpowiedzi
                    };
               };};
          if(@$_POST['questionC']){
               foreach(@$_POST['questionC'] as $id => $value){
                         @$input .= '('.$id.',0,3,"'.$value.'",0,"") ,';        //wczytywanie pytan otwartych 
               };};
               if(@$_POST['answerContent']){
                    print("<script>");
                    foreach(@$_POST['answerContent'] as $id => $value){
                         foreach($value as $Cid => $current){
                              if(@$_POST['answerCorrect'][$id][$Cid]){
                                   @print("document.getElementsByName('answerCorrect[$id][$Cid]')[0].checked = ".validateState($_POST['answerCorrect'][$id][$Cid]).";"); //zaznaczanie poprawnych odpowiedzi
                              };
                         };
                    };
                    print("</script>");
               };
               if($input && $_SESSION['input'] == 0){       //sprawdzanie sesji input oraz czy kwerenda zapisujaca istnieje
                    $input = substr($input, 0, -1);
                    $truncate = mysqli_query($examsConnect, "TRUNCATE TABLE `exams`.`$Gid`");
                    $send = mysqli_query($examsConnect, $input);
                    print('<script>window.open("http://localhost/exams/main.php", "_self");</script>');
                    $_SESSION['input'] = 1;
               };
               };
          };
          mysqli_close($examsConnect);
          mysqli_close($mainConnect);
          mysqli_close($connectAnswers);


     ?>

<script>
               document.getElementById("closed").addEventListener("click" , ()=>{
                    
                    const questionCounter = gCounter;  var sCounter = 0;

                    var form = document.createElement("div");    
                    var formDeleter = document.createElement("button");    
                    var answerAdder = document.createElement("button");    
                    var question = document.createElement("textarea");  
                    var ref = document.getElementById("check");
                    var grid = document.createElement("div");
                    grid.className = "operational";


                    
                    
                    formDeleter.setAttribute("onclick","remove(this.parentNode.parentNode);");


                    answerAdder.addEventListener("click", () => {
                         sCounter += 1;
                         var radio = document.createElement("input"), label = document.createElement("label"), answer = document.createElement("textarea");
                         var parent = document.createElement("div"), answerDeleter = document.createElement("button");
                         
                         radio.type = "checkbox";      
                         radio.name = "answerCorrect["+ questionCounter +"]["+sCounter+"]";    
                         radio.value = false;


                         answerDeleter.type = "button";
                         answerDeleter.className = "garbageCan";
                         answerDeleter.setAttribute("onclick","remove(this.parentNode);");
                         answerDeleter.className = "garbageCan";



                         answer.placeholder = "Podaj odpowiedź";      
                         answer.name = "answerContent["+ questionCounter +"]["+sCounter+"]";       
                         answer.style = 'resize : none;';
                         answer.className = "answer";


                         label.htmlFor = "answerContent["+ questionCounter +"]["+sCounter+"]";      
                         label.className = "answerCorrect["+ questionCounter +"]["+sCounter+"]";
                        

                         label.appendChild(radio);     parent.appendChild(answer);     parent.appendChild(label);       parent.appendChild(answerDeleter);      form.appendChild(parent);
                    });
                    question.placeholder = "Treść pytania";
                    question.name = "question["+ questionCounter +"]";
                    question.style = 'resize : none;';
                    question.className = "question";
                    
                    answerAdder.type = "button";
                    answerAdder.className = "add";
                    answerAdder.innerHTML = "Dodaj odpowiedź";


                    formDeleter.type = "button";
                    formDeleter.className = "remove";
                    formDeleter.innerHTML = "Usuń pytanie";

                    
                    form.className = "que";
                    
                    grid.appendChild(question);
                    grid.appendChild(answerAdder);
                    grid.appendChild(formDeleter);
                    form.appendChild(grid);

                    document.getElementById("form").insertBefore(form , ref);
                    gCounter += 1;
                    
               });
               document.getElementById("opened").addEventListener("click", () => {
                    
                    const questionCounter = gCounter;
                    var answer = document.createElement("textarea");
                    var form = document.createElement("div");
                    var formDeleter = document.createElement("button");
                    var question = document.createElement("textarea");  
                    var ref = document.getElementById("check");
                    var grid = document.createElement("div");
                    grid.className = "operational";



                    formDeleter.setAttribute("onclick","remove(this.parentNode);");


                    question.placeholder = "Treść pytania";
                    question.name = "questionC["+ questionCounter +"]";
                    question.style = 'resize : none;';
                    question.className = "question";

                    answer.name = "answerContent["+ questionCounter +"][1]";
                    answer.style = 'resize : none;';
                    answer.className = "answer";

                    formDeleter.type = "button";
                    formDeleter.className = "remove";
                    formDeleter.innerHTML = "Usuń pytanie";


                    form.className = "queC";
                    
                    form.appendChild(question);
                    form.appendChild(answer);
                    form.appendChild(formDeleter);
                    
                    document.getElementById("form").insertBefore(form , ref);
                    gCounter += 1;
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