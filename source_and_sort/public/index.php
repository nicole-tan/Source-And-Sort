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
        <input type="submit" name = "submit" value= "Submit" class= "button_style" onclick= "toggle_visibility('summary');">
        <br>
      </form> 

      <?php 
        error_reporting(E_ERROR | E_PARSE);
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
          foreach($arr as $key => $val){
            if( is_array($val) ) {
                print_r ($tabs . $key . " : ".">"."<br />");
                pretty($val, $level + 1);
            } 
            else {
              if($val && $val !== 0){
              print_r ($tabs . $key. " ". $val .">"."<br />"); 
              }
            }
          }
        }

        ?>
         <div id= "prettyPrint">
          <?php pretty($pieces) ?>
        </div> 
      </div> 
 

      <div id = "summary">
            <p> Summary: </p>
          <input type= "submit" onclick= "clear_screen();" id= "clear_button" value= "Clear">
          <br>
      <?php
        echo "<div id = summary_info>";
        $search = preg_match_all('/<([^\/!][a-z1-9]*)/i', $pagerequest,$matches);
        $tagCount = (array_count_values($matches[1])); 
        foreach($tagCount as $key => $value) {
          echo "<input type= \"submit\" onclick = highlight('$key');show_div('$key') class = \"button_style\" value= $key>".' '.$value."<br>"; }
      ?>
        </div>
          <div id= "line_location" style= "color: white; display: none; width: 50%; float: right; height: 100%">
          <p> Line location(s) of tag: </p>
          </div>
      </div>




    <script type= "text/javascript"> 

    var arr = [];
    var new_string = "";
    var dict = [];

      function toggle_visibility(id) {
        console.log('in toggle visibility');
        var elt = document.getElementById(id);
        if (elt && elt.style.display == 'none') 
          elt.style.display = 'block';
        else 
          elt.style.display = 'none';
        }

      function highlight(text) {
          var greatertext = '&lt;' + text;
          var replacement = new RegExp(greatertext, "g");
         if ((replacement).test(document.getElementById("prettyPrint").innerHTML)) {
            document.getElementById("prettyPrint").innerHTML = document.getElementById("prettyPrint").innerHTML.replace(
            new RegExp(greatertext + '(?!([^<]+)?>)', 'gi'),
            '<b style= "background-color:#a6e22d;font-size:100%">$&</b>'
        );
          /**document.getElementById("prettyPrint").innerHTML = document.getElementById("prettyPrint").innerHTML.replace(
            new RegExp('&lt;' + '(?!([^<]+)?>)', 'gi'),
            '<span style= "background-color:#44453f; color: white; font-weight: normal">$&</span>'
        ); **/
            arr.push(greatertext);
      }
    }

    function clear_screen() {
      for (i = 0; i < arr.length; i++) {
        var elt = arr[i];
        var replacement = new RegExp(elt, "g");
        if ((replacement).test(document.getElementById("prettyPrint").innerHTML)) {
            document.getElementById("prettyPrint").innerHTML = document.getElementById("prettyPrint").innerHTML.replace(
            new RegExp(elt + '(?!([^<]+)?>)', 'gi'),
            '<span style= "background-color:#44453f;color: white; font-weight: normal">$&</span>'
        );
        }
        new_string = "";
        document.getElementById("line_location").innerHTML = "Line location(s) of tag:" + "<br>";
      }
    }

    function show_div(key) {
      console.log('in show div');
      var div = document.getElementById("line_location");
      new_string = new_string.concat(key + ':' + '<br>');
      div.innerHTML = div.innerHTML + new_string;
      new_string = "";
      div.style.display = "inline-block";
    }

    function find_line_number(key) {
      //goes through source code and uses regex to find the closest line number to the left that corresponds to each key
      //lists each line number in the value which is stored as an array in the global dictionary dict
    }


    </script>
  </body>
</html>
