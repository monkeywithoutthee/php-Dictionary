<?php

    $view_variable = 'a string here';
    $view_variable2 = 'aother string here';

    $servername = "localhost";
    $username = "root";
    $password = "M00np1g#";

    echo $_POST['username'];
    echo $_REQUEST['username'];

    $cookie_value = "";
    $cookie_name = "lastpost";

    if (isset($_COOKIE[$cookie_value])){
      $cookie_value = $_COOKIE[$cookie_value];
    }

    try {
      $conn = new PDO("mysql:host=$servername;dbname=DRC", $username, $password);
    #  // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      #echo "Connected successfully";
      console_log("Connected successfully");
    } catch(PDOException $e) {
      #echo "Connection failed: " . $e->getMessage();
      console_log("Connection failed: " . $e->getMessage());
    }

?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
  <head>
    <meta charset="UTF-8">
    <title>MAMP</title>
    <link rel="stylesheet" href="css/index.css" />
  </head>
  <body>
    <div class="card">
    <form action="" method="post">
      <div class="headFormH">
        <div class="headForm">word:  <input type="text" name="word" /></div>
        <div class="headForm"><input class="submit" type="submit" value="Look Up Word!" /></div>
      </div>
    </form>

    <?php
    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
    ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
    ?>

    <?php

    if ($_POST) {
        if ($_POST['word']){
          $word = $_REQUEST['word'];
          console.log('$word::',$word);
          if ($word===""){
            $noWord = "<script>alert('please enter a word!');return false;</script>";
            echo $noWord;
          }
          $cookie_value = $word;
          $query = 'CALL getWord("'.$word.'", 0)';//this is it!
          $i = 0;
          $formatedText = "";
            foreach($conn->query($query) as $row) {
              if ($i===0){
                $formatedText = formatText($row['definition']);
                console_log($row['definition'].'<<formatedText::'.$formatedText);
              }
                echo '<div>';
                echo '<div class="innerRow divwod">' . $row['word'] . '</div>';
                echo '<div class="innerRow divdef">' . $formatedText . '</div>';
                echo '</div>';
                $i = i + 1;
            }
              setcookie($cookie_name,$cookie_value);
            if ($i === 0 && $word !== ""){
              echo '<div>';
              echo '<div class="innerRow">' . $word . ' is not a word!</div>';
              echo '</div>';
            }

            console_log($i . '<<POSTED::',$_REQUEST['word']);
        }
    }else{
      console_log('<<POSTED????::');
    }

    function formatText($data){

      $dataArr =str_split($data);
      console_log(count($dataArr).'<<IN formatText::'.$data);
      $formattedTxt = '';
      if (count($dataArr)>0){
        console_log('prelooping::');
        for ($i=0; $i < count($dataArr); $i++){

            console_log($dataArr[$i].'<<looping entry::');
            if ($dataArr[$i] === '.'){//formating on period

                if ($i> 0 && $i< (count($dataArr)-1)){
                  console_log(!is_nan($dataArr[$i-1]).'<<looping FULL STOP compare::'.$dataArr[$i-1].' - - '.$dataArr[$i*1+1]);
                  if (!is_nan($dataArr[$i-1])&&$dataArr[$i*1+1]==' '){//number before so skip the break!
                    $formattedTxt .= $dataArr[$i];
                  }else{
                    //just do it
                    console_log(!is_nan($dataArr[$i-1]).'<<looping DO IT::'.(count($dataArr)-1));
                    $formattedTxt .= $dataArr[$i].'<BR>';
                  };
                }else{
                  //first letter, just do it
                  $formattedTxt .= $dataArr[$i];
                };
            }else{
              //first letter, just do it
              $formattedTxt .= $dataArr[$i];
            };

          };
        }
      return $formattedTxt;
    }
    ?>

    <?= console_log('zzzz' . $view_variable); ?>


    <script>
    // other JavaScript code before ...

    var js_variable_as_placeholder = <?= json_encode($view_variable2,
        JSON_HEX_TAG); ?>;
    console.log('booom::',js_variable_as_placeholder);

    // other JavaScript code and after ...
    </script>
  </div>
  </body>
</html>
