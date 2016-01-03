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
          echo "<input type= \"submit\" onclick = highlight('$key');show_div() class = \"button_style\" value= $key>".' '.$value."<br>"; }
      ?>
        <!-- </div>
          <div id= "line_location" style= "display:none; margin-right: 80px; color: white; float: right;">
          <p> Line location(s) of tag: </p>
          </div> -->
      </div>




    <script type= "text/javascript"> 

    var arr = [];

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
      }
    }

    function show_div() {
      document.getElementById("line_location").style.display = "";
    }

   /** function line_display() {
      var line_tag_array = <?php echo json_encode(pretty($pieces)) ?>;
      for(i = 0; i < line_tag_array.length; i++) {

      }

    } **/

    </script>
  </body>
</html>
