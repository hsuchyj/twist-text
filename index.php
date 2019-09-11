<!-- Works as game but how to incorporate required milestones? ask novo-->
<!DOCTYPE html>
<html>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
 
<body>

<?php
	$dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
	
    $query = "SELECT rack, words FROM racks WHERE length=7 and weight <= 10 order by random() limit 0, 1";

    $statement = $dbhandle->prepare($query);
    $statement->execute();
    
    $results = $statement->fetch(PDO::FETCH_ASSOC);
    $words_arr = explode("@@", $results["words"]);
    
    echo json_encode($results) . "<br>";
     
    
    echo "Rack: <b>" . $results["rack"]. "</b>";
    echo "<br><br>";
    
    
    echo "Possible words: <br>";
    $count = 0;
    foreach($words_arr as $word)
    {
        echo "<div id =".$count.">".str_repeat("*", strlen($word)) . "</div>";
        $count++;
    }
    
    echo "<br>";
    //SANITIZE THIS INPUT
    echo "Guess:<input type = 'text' id = 'guess'></input>";
?>    
<button id='check'>Check</button>
</body>
<script>
 $(document).ready(function(){
     
      let score = 0;
      let c_guesses = [];
      $("#check").on("click", function()
      {
        //make rack variable an ajax request so it doesnt show in js?
        let rack = <?php echo json_encode($words_arr); ?>;
        let guess = document.getElementById("guess").value.toUpperCase();
        let correct = rack.includes(guess);
        let guessed = c_guesses.includes(guess);
        //alert(score);
        //alert(correct);
        if(correct && !guessed)
        {
               document.getElementById(score).innerHTML = guess;
               score++;
               c_guesses.push(guess);
        }
        else if(guessed)
        {
            alert("Already guessed. Try Again.");
        }
        else
        {
            alert("Wrong. Try again.");
        }
        
        if(score == rack.length)
        {
            alert("You win!");
        }
        
      });
    });
</script>
</html>