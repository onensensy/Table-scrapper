<?php

//database conection
$db_username = 'root';
$db_password = '';
$conn = new PDO( 'mysql:host=localhost;dbname=scrap', $db_username, $db_password );

if(!$conn){
    die("Fatal Error: Connection Failed!");
}

//Return URL in the form on running
function value()
{
    if (isset($_POST['site'])) { 
        echo $_POST['site'];
    }

}


//Results
function resuts(){
// // Create DOM from URL or file
// $html = file_get_html("http://www.example.org/");
// // Find the tr array
// $tr_array = $html->find("table#table2 tr");
// $td_array = [];
// // Find the td array
// foreach($tr_array as $tr) {
// array_push($td_array,$tr->find("td"));
// }
// echo "<table id=\"table1\">";
    // foreach($tr_array as $tr) {
    // echo "<tr>";
        // foreach($td_array as $td) {
        // echo $td;
        // }
        // echo "</tr>";
    // }
    // echo "</table>";
///////////////////////////////////////////////////////
    
 //initialize the connection with cURL (ch = cURL handle, or "channel")
$ch = curl_init();
//Get the link from the form
$site=$_POST['site'];
//set link to curl
curl_setopt($ch, CURLOPT_URL, $site);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//send the request and store it in $html
$html = curl_exec($ch);
// var_dump($html);
$dom = new DOMDocument();
@$dom->loadHTML($html);
$pack_array = array();
foreach($dom->getElementsByTagName('table') as $table){
$head_title = $table->textContent;
echo $head_title .'<br>';
echo '<br>';
}
//////////////////////////////////////////////////////

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrapper</title>
</head>
<style type="text/css">
body {
    background-color: whitesmoke;
}

form {}

#heading {
    font-size: 25px;
    font-family: sans-serif;
}

#form-container {
    align-content: center;
    color: darkgoldenrod;
    font-size: 20px;
    width: fit-content;
    margin: 50px;
    border-radius: 0%;
}

#Site {
    border-radius: 15%;
    height: 20px;
    width: 250px;
}

#form-content {
    align-content: center;
}

input {
    vertical-align: center;
}

hr {
    width: 70%;
}
</style>

<body>
    <center>
        <div id="heading">
            <h1>Table scrap Tool</h1>
        </div>
        <hr>
        <div id="form-container">
            <form action="index.php" method="post">
                <div id="form-content"><label>Site:</label>
                    <input type='text' id="Site" name='site' value="<?php value(); ?>" placeholder="Enter the site URL here">
                    <input type='submit' name='Scrap'><br></div>
            </form>
        </div>
        <div id="results">
            <?php if (isset($_POST['site'])){?>
            <center>
                <div>
                    <h3>Results for</h3>
                    <a href="<?php value(); ?>">
                        <?php value(); ?></a>
                    <hr style="width:40%;">
                </div>
            </center>
            <?php resuts();  } ?>
        </div>
    </center>
</body>

</html>