<?php
	$dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
	if($_GET["button"] == "newRack")
	{
        $query = "SELECT rack, words FROM racks WHERE length=7 and weight <= 10 order by random() limit 0, 1";
    
        $statement = $dbhandle->prepare($query);
        $statement->execute();
        
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($results);
	//$words_arr = explode("@@", $results["words"]);
	//echo json_encode($words_arr);
    //$words_arr = explode("@@", $results["words"]);
	}
	else if($_GET["button"] == "check")
	{
	    $query = "select * from racks where rack = '" . $_GET["rack"]."'";
	    $statement = $dbhandle->prepare($query);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $word_arr = explode("@@", $row["words"]);
        $arr1 = array("result" => "incorrect");
        $arr2 = array("result" => "correct" , "guess"=>$_GET["guess"]);
        if(in_array($_GET["guess"], $word_arr))
        {
            //if correct
            echo json_encode($arr2);
        } 
        else
        {
            echo json_encode($arr1);
        }
	}
?>