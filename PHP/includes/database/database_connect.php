<?php
    //echo shell_exec("ssh -L 3306:ytc353_1.encs.concordia.ca:3306 login.encs.concordia.ca");
    // Database info
    $servername = null;
    $dbName = null;
    $username = null;
    $password = null;
    $connection = null;
	
    if(strpos($_SERVER["HTTP_HOST"],"ytc353_1") !== false){
        $servername = "ytc353_1.encs.concordia.ca";
        $dbName = "ytc353_1";
        $username = "ytc353_1";
        $password = "jdcasyra";
        $connection = null;
    }
    else{
        $servername = "localhost";//"ytc353_1.encs.concordia.ca";
        $dbName = "ytc353_1";
        $username = "root";//"ytc353_1";
        $password = "";//"jdcasyra";
        $connection = null;
    }

    // Attempt to connect
    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbName;", $username, $password);

        // Error mode
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //echo "Connected successfully"; 
    }
    catch(PDOException $e){
        echo "Failed to connect: " . $e->getMessage();
    }
?>