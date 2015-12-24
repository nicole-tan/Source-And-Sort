<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Source and Sort</title>
    <link rel="stylesheet" href="css/styles.css"/>
  </head>
  <body>
    <div id = "navBar">
      <p> Source and Sort </p>
    </div> <!-- End navBar div-->
    <div id = "requestForm">
      <form name= "url" action= "index.php" method= "POST" id = "urlField"> 
        <p id = "enterUrl"> Please enter a URL here: </p>
        <input type="url" name = "url" id = "url">
        <input type="submit" name = "submit" value= "Submit" id = "submit">
      </form> 

      <?php 
        if (isset($_POST['submit'])) {
        $pageurl = $_POST['url'];
        }

        $pagerequest = file_get_contents($pageurl);
        $pagevar = htmlentities($pagerequest);
        $pieces = explode("&gt;", $pagevar);

        function pretty($arr, $level=0){
        $tabs = "";
        for($i=0;$i<$level; $i++){
            $tabs .= "    ";
        }
            foreach($arr as $key=>$val){
                if( is_array($val) ) {
                    print_r ($tabs . $key . " : ".">"."<br />");
                    pretty($val, $level + 1);
                } else {
                    if($val && $val !== 0){
                        print_r ($tabs . $val .">"."<br />"); 
                    }
                }
            }
        }

        echo '<div id= "prettyPrint">';
        pretty($pieces); 
        echo '</div>';

    echo '</div>'; //end requestForm div

    echo '<div id = "summary">';
      echo '<p> Summary: </p>';
        $search = preg_match_all('/<([^\/!][a-z1-9]*)/i', $pagerequest,$matches);
        echo "<div id= \"summaryInfo\">";
        $tagCount = (array_count_values($matches[1]));
        foreach($tagCount as $key => $value)
          echo "<input type= \"submit\" onclick = highlight('$key') value= $key>".' '.$value."<br>";
        echo "</div>"; //end summaryInfo div
    echo '</div>' // end summary div  
      ?>

    <script type= "text/javascript"> 
      function highlight(text) {
        document.body.innerHTML = document.body.innerHTML.replace(
            new RegExp(text + '(?!([^<]+)?>)', 'gi'),
            '<b style="background-color:#a6e22d;font-size:100%">$&</b>'
        );
      }
    </script>
  </body>
</html>
