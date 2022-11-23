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


///////////////////
//site: https://www.visualcapitalist.com/top-50-most-valuable-global-brands/
//table id="tablepress-1345"
//////////////////

//Store data in array
$data = array();


// get all table rows including header
$table_rows = $xpath->query('//table[@id="tablepress-1345"]//tr');
// $table_rows = $xpath->query('//table[@id="table1"]//tr');
foreach($table_rows as $row => $tr) {
    foreach($tr->childNodes as $td) {
        $data[$row][] = preg_replace('~[\r\n]+~', '', trim($td->nodeValue));
    }
    $data[$row] = array_values(array_filter($data[$row]));
}


//Array Size ( Also to determine the table dimensions(Row & Column))
$rows=sizeof($data,0);
$columns = (sizeof($data,1)/$rows)-1;

//Serialize data for storage to database
$serial = utf8_encode( serialize( $data ) ) ;
    //echo $serial;


//Insert into Database
$sql="INSERT into `scrapRecord`(id,scrapTime,data) VALUES(id,current_timestamp(),?)";
$result=$conn->prepare($sql);
$result->execute([$serial]);



//Output Number of rows and columns
?>
<div class="parent container-row-column">
    <div class="child columns">
        <?php echo "<code>Attributes: $columns</code>"."<br>";?>
    </div>
    <div class="child rows">
        <?php $records=$rows-1; echo "<code>Records: $records </code>"; ?>
    </div>
    <?php if ($result == true) { ?>
    <div class="record">
        <?php echo "Recorded Successfully!<br>"; ?>
    </div>
</div>
<hr style="width: 100%%;">
<?php 
}


// print_r($data);

//Output data into a table
?>
<table id="results" style='border-spacing:0;width:70%;border-collapse:"collapse"'>
    <?php
    for ($i=0; $i <= ($rows-1); $i++) { ?>
    <tr>
        <?php 
            for ($j=0; $j <= ($columns-1); $j++) { 
                if ($i==0) {?>
        <th style="background: rgb(82, 80, 80); color: #FAF9F6;">
            <?php echo $data[$i][$j];?>
        </th>
        <?php }else{ ?>
        <td>
            <?php echo $data[$i][$j];?>
        </td>
        <?php } ?>
        <?php } ?>
    </tr>
    <?php }?>
</table>
<?php 
}
////////////////////////////////////////////////////////////////////////////////////////////
?>
<!-- ------------------------------------------------------------------------------------ -->
<!-- HTML body -->
<!-- ------------------------------------------------------------------------------------ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrapper</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <main>
        <div class="heading">
            <h1>TABLE SCRAP TOOL</h1>
        </div>
        <div class="container">
            <form action="index.php" method="post">
                <div class="site">
                    <input type='text' id="Site" name='site' value="<?php value(); ?>" placeholder="Enter the site URL here">
                </div>
                <div class="submit-btn">
                    <input type='submit' name='Scrap' value="Search">
                </div>
            </form>
        </div>
        <div id="results">
            <?php if (isset($_POST['site'])){?>
            <div class="results-for">
                <h4>Results for</h4>
                <a href="<?php value(); ?>" target="_blank">
                    <?php value(); ?></a>
            </div>
        </div>
        <?php resuts();  } ?>
    </main>
</body>

</html>