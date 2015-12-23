<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>React Tutorial</title>
    <!-- Not present in the tutorial. Just for basic styling. -->
    <link rel="stylesheet" href="css/styles.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.0/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.14.0/react-dom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.2/marked.min.js"></script>
  </head>
  <body>
    <div id = "navBar">
      <p> Source and Sort </p>
    </div> <!-- End navBar div-->

    <div id = "requestForm">
      <form name= "url" action= "index.php" method= "POST" id = "urlField"> 
        <p id = "enterUrl"> Please enter a URL here: </p>
        <input type="url" name = "url" id = "url">
        <input type="submit" name = "submit" value= "Submit">
        </br>
      </form> 

      <?php 
        if (isset($_POST['submit'])) {
        $pageurl = $_POST['url'];
        }

        $pagerequest = file_get_contents($pageurl);
        $pagevar = htmlentities($pagerequest);
        $pieces = explode("&gt;", $pagevar);
        //echo $pieces[2]; 
        //print_r($pieces);

        //http://stackoverflow.com/questions/1168175/is-there-a-pretty-print-for-php
        //redo this function later 
        function pretty($arr, $level=0){
        $tabs = "";
        for($i=0;$i<$level; $i++){
            $tabs .= "    ";
        }
            foreach($arr as $key=>$val){
                if( is_array($val) ) {
                    print_r ($tabs . $key . " : " . "\n".">"."<br />");
                    pretty($val, $level + 1);
                } else {
                    if($val && $val !== 0){
                        print_r ($tabs . $val . "\n".">"."<br />"); 
                    }
                }
            }
        }

        echo '<div id= "prettyPrint">'."<br>";
        pretty($pieces); 
        echo '</div>';


        $search = preg_match_all('/<([^\/!][a-z1-9]*)/i', $pagerequest,$matches);
        echo "<div id= \"summaryInfo\">";
        $tagCount = (array_count_values($matches[1]));
        foreach($tagCount as $key => $value)
          echo "<input type= \"submit\" onclick = highlight('$key') value= $key>".' '.$value."<br>";
        echo "</div>"; //end summaryInfo div

      ?>


        <!--  echo "<script type= \"text/javascript\"> 
          function highlight(text) {
            inputText = document.getElementById(\"prettyPrint\");
            var innerHTML = inputText.innerHTML;
            var index = innerHTML.indexOf(text);
            if (index >= 0)
            {
              innerHTML = innerHTML.substring(0, index) + \"<span class = 'highlight'>\" + innerHTML.substring(index,
                index+text.length) + \"</span>\" + innerHTML.substring(index + text.length);
              inputText.innerHTML = innerHTML;
              document.write(\"I got here!\");
            }
          }
          </script>

          <style>
          .highlight {
            background-color: yellow;
            }
          </style>"; -->
    <script type= "text/javascript"> 
      function highlight(text) {
        inputText = document.getElementById("prettyPrint");
        var innerHTML = inputText.innerHTML;
        var index = innerHTML.indexOf(text);
        if (index >= 0)
        {
          innerHTML = innerHTML.substring(0, index) + "<span class = 'highlight'>" + innerHTML.substring(index,
            index+text.length) + "</span>" + innerHTML.substring(index + text.length);
          inputText.innerHTML = innerHTML;

        }
      }
      </script>

      <style>
      .highlight {
        background-color: yellow;
      }
      </style> 

    </div> <!--End requestForm div-->

    <div id = "summary">
      <p> Summary: </p>
      <!-- What do you want to do here?
      so pretty much have a list of all the tags
      and then check to see if they are present in the php array
      if they are present create a button and a running count
      if they are not present do not create a button
      I guess we're going to do this in javascript?
      So have an extra script on the side?
      They also have to highlight parts within the source code-->


    </div> <!-- End summary div --> 
  </body>
</html>
