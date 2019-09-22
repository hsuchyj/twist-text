<!-- Works as game but how to incorporate required milestones? ask novo-->
<!DOCTYPE html>
<html>
<head>
    <style>
        body{
          color:#FFD700;  
}
    </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
 
<body bgcolor = "264FDB">
<button id='newRack'>New Rack</button>
<br><br>
<b>Rack:</b><div id = "rack"></div>
<br>
<b>Possible words:</b><br><div id = "words"></div>
<br>
<b>Guess:</b><input type = 'text' id = 'guess'></input>
<button id='check'>Check</button>
</body>
<script>
 $(document).ready(function(){
     
	 let score = 0;
     let c_guesses = [];
	 let word_arrLength = 0;
	 let word_l = 0;
	  
	function newRack(rack)
	{
	    //Display new rack
	    let hidden = "";
	    score = 0;
        c_guesses = [];
	    alert(rack["words"] + " (use for testing)");
	    var word_arr = rack["words"].split("@@");
	    word_l = word_arr[0].length;
	    word_arrLength = word_arr.length;
		for(var i = 0; i < word_arr.length; i++) 
		{
				let star = "*";
				let line = star.repeat(word_arr[i].length);
				hidden = hidden + line + "<br>";
		}
		
		document.getElementById("words").innerHTML = hidden;
		document.getElementById("rack").innerHTML = rack["rack"];
	}
	
	function displayCheck(grade)
	{
	    //Load new words
	   let hidden = "";
	   //if correct word wasnt guessed yet
	   if(!c_guesses.includes(grade["guess"]) && grade["result"] == "correct")
	   {
	       c_guesses.push(grade["guess"]);
	       score++;
	       //print correct words
	       for(var i = 0; i < c_guesses.length; i++)
	       {
	           hidden = hidden + c_guesses[i] + "<br>";
	       }
	       //determine number of words left to print
	       for(var i = 0; i < word_arrLength-score; i++) 
		   {    
				let star = "*";
				let line = star.repeat(word_l);
				hidden = hidden + line + "<br>";
		   }
		
	       document.getElementById("words").innerHTML = hidden;
	       
	       if(score==word_arrLength)
	       {
	           alert("You WIN! New rack incoming");
	            $.ajax({
                    method: "GET",
                    url: "api.php?button=newRack",
                    dataType: 'json',
                    success: data=>{ newRack(data)}
                });
	       }
	   }
	   else
	   {
	       alert("Incorrect or already guessed.");
	   }
	}
	
      $("#newRack").on("click", function()
      {
        $.ajax({
            method: "GET",
            url: "api.php?button=newRack",
            dataType: 'json',
            success: data=>{ newRack(data)}
        });
      });
	  
	  $("#check").on("click", function()
      {
        let guess = document.getElementById("guess").value.toUpperCase();
        let rack = document.getElementById("rack").innerHTML;
        
        $.ajax({
            method: "GET",
            url: "api.php?button=check&guess=" + guess + "&rack="+ rack,
            dataType: 'json',
            success: grade=>{ displayCheck(grade)}
        });
      });
	  
    });
</script>
</html>