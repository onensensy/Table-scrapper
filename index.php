<?php

//database conection
$db_username = 'root';
$db_password = '';
$GLOBALS['conn'] = new PDO( 'mysql:host=localhost;dbname=scrap', $db_username, $db_password );

if(!$conn){
    die("Fatal Error: Connection Failed!");
}

//SQL statement
//Return URL in the form on running
function value()
{
    if (isset($_POST['site'])) { 
        echo $_POST['site'];
    }

}


//Results
function resuts(){
global $conn;
//initialize the connection with cURL (ch = cURL handle, or "channel")
$ch = curl_init();
//Get the link from the form
$site=$_POST['site'];

/////////////////////////////////////////////////////
curl_setopt($ch, CURLOPT_URL, $site);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($ch);

$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($page);
libxml_clear_errors();
$xpath = new DOMXpath($dom);
// 
//https://www.visualcapitalist.com/top-50-most-valuable-global-brands/
$data = array();
// get all table rows and rows which are not headers
$table_rows = $xpath->query('//table[@id="tablepress-1345"]//tr');
foreach($table_rows as $row => $tr) {
    foreach($tr->childNodes as $td) {
        $data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
    }
    $data[$row] = array_values(array_filter($data[$row]));
}


//Array Size
$rows=sizeof($data,0);
$columns = (sizeof($data,1)/$rows)-1;

//Serialize
$serial = utf8_encode( serialize( $data ) ) ;
//echo $serial;


//Insert into Database
$sql="INSERT into `scrapRecord`(scrapTime,data) VALUES(current_timestamp(),?)";
$result=$conn->prepare($sql);
$result->execute([$serial]);
if ($result == true) {
<<<<<<< HEAD
                echo "Recorded Successfully<br>";
            }

//Output Number of rows and columns
echo "Rows: $rows" ."<br>";
=======
                echo "Record Successfull<br><br>";
            }

//Output Number of rows and columns
echo "Row: $rows" ."<br>";
>>>>>>> 96b33cc72d3dcc13a1bebffb052eea8ddf65e672
echo "Columns: $columns";
echo '<pre>';
// print_r($data);



//Output data into a table
?>
<<<<<<< HEAD
<table id="results" style='border-spacing:0;width:70%;border-collapse:"collapse"'>
=======
<table id="results">
>>>>>>> 96b33cc72d3dcc13a1bebffb052eea8ddf65e672
    <?php
for ($i=0; $i <= ($rows-1); $i++) { ?>
    <tr>
        <?php 
    for ($j=0; $j <= ($columns-1); $j++) { ?>
        <td>
            <?php echo $data[$i][$j];?>
        </td>
        <?php }             
        ?>
    </tr>
    <?php }?>
</table>
<?php 

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrapper</title>
<<<<<<< HEAD
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <main>
    <div class="heading">
            <h1>TABLE SCRAP TOOL</h1>
        </div>
        <div>
            <form action="index.php" method="post">
                <div class="site">
                    <input type='text' id="Site" name='site' value="<?php value(); ?>" placeholder="Enter the site URL here">
                </div>
                <div class="submit-btn">
                    <input type='submit' name='Scrap' value="Submit">
                </div>
=======
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
>>>>>>> 96b33cc72d3dcc13a1bebffb052eea8ddf65e672
            </form>
        </div>
        <div id="results">
            <?php if (isset($_POST['site'])){?>
<<<<<<< HEAD
            <div class="results-for">
                <h3>Results for</h3>
                <a href="<?php value(); ?>" target="_blank">
                    <?php value(); ?></a>
            </div>
        </div>
    <?php resuts();  } ?>
    </main>
=======
            <div>
                <h3>Results for</h3>
                <a href="<?php value(); ?>" target="_blank">
                    <?php value(); ?></a>
                <hr style="width:40%;">
            </div>
        </div>
    </center>
    <?php resuts();  } ?>
>>>>>>> 96b33cc72d3dcc13a1bebffb052eea8ddf65e672
</body>

</html>