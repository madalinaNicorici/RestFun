
function getQuestion(){
	if(i>0){
		if(rightAns==1)
			if (document.getElementById('r1').checked) {
				score=score+1;
				document.getElementById("previous").innerHTML = "You answered your last question right!";
			}
			else{
				document.getElementById("previous").innerHTML = "You answered your last question wrong!";
			}
		if(rightAns==2)
			if (document.getElementById('r2').checked) {
				score=score+1;
				document.getElementById("previous").innerHTML = "You answered your last question right!";
			}
			else{
				document.getElementById("previous").innerHTML = "You answered your last question wrong!";
			}
		if(rightAns==3)
			if (document.getElementById('r3').checked) {
				score=score+1;
				document.getElementById("previous").innerHTML = "You answered your last question right!";
			}
			else{
				document.getElementById("previous").innerHTML = "You answered your last question wrong!";
			}
		if(rightAns==4)
			if (document.getElementById('r4').checked) {
				score=score+1;
				document.getElementById("previous").innerHTML = "You answered your last question right!";
			}
			else{
				document.getElementById("previous").innerHTML = "You answered your last question wrong!";
			}
		localStorage.playerScore = score;
	}
	if(i<10)
	{
		document.getElementById("hintSpace").innerHTML = '<button type="button" class="btn btn-success" onclick="showHint()">Hint</button>';
		var mygetrequest = new ajaxRequest()
		
		mygetrequest.onreadystatechange=function()
		{
			
			if (mygetrequest.readyState==4)
			{
				if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1)
				{
					var json = JSON.parse(mygetrequest.responseText)
					questionHint=json.message.hint;
					document.getElementById("source").innerHTML = '<a href="'+json.message.source+'">Click here!</a>';
					rightAns = Math.floor((Math.random() * 4) + 1);
					document.getElementById("question").innerHTML = escapeHtml(json.message.q_body);
					if(rightAns==1){
						document.getElementById("q1").innerHTML = '<form><input type="radio" name="ans" id="r1"  value="1">'+escapeHtml(json.message.answer_r);
						document.getElementById("q2").innerHTML = '<input type="radio" name="ans" id="r2"  value="2">'+escapeHtml(json.message.answer_w1);
						document.getElementById("q3").innerHTML = '<input type="radio" name="ans" id="r3"  value="3">'+escapeHtml(json.message.answer_w2);
						document.getElementById("q4").innerHTML = '<input type="radio" name="ans" id="r4"  value="4">'+escapeHtml(json.message.answer_w3)+'</form>';
					}
					if(rightAns==2){
						document.getElementById("q1").innerHTML = '<form><input type="radio" name="ans" id="r1"  value="1">'+escapeHtml(json.message.answer_w1);
						document.getElementById("q2").innerHTML = '<input type="radio" name="ans" id="r2"  value="2">'+escapeHtml(json.message.answer_r);
						document.getElementById("q3").innerHTML = '<input type="radio" name="ans" id="r3"  value="3">'+escapeHtml(json.message.answer_w2);
						document.getElementById("q4").innerHTML = '<input type="radio" name="ans" id="r4"  value="4">'+escapeHtml(json.message.answer_w3)+'</form>';
					}
					if(rightAns==3){
						document.getElementById("q1").innerHTML = '<form><input type="radio" name="ans" id="r1"  value="1">'+escapeHtml(json.message.answer_w2);
						document.getElementById("q2").innerHTML = '<input type="radio" name="ans" id="r2"  value="2">'+escapeHtml(json.message.answer_w1);
						document.getElementById("q3").innerHTML = '<input type="radio" name="ans" id="r3"  value="3">'+escapeHtml(json.message.answer_r);
						document.getElementById("q4").innerHTML = '<input type="radio" name="ans" id="r4"  value="4">'+escapeHtml(json.message.answer_w3)+'</form>';
					}
					if(rightAns==4){
						document.getElementById("q1").innerHTML = '<form><input type="radio" name="ans" id="r1"  value="1">'+escapeHtml(json.message.answer_w3);
						document.getElementById("q2").innerHTML = '<input type="radio" name="ans" id="r2"  value="2">'+escapeHtml(json.message.answer_w1);
						document.getElementById("q3").innerHTML = '<input type="radio" name="ans" id="r3"  value="3">'+escapeHtml(json.message.answer_w2);
						document.getElementById("q4").innerHTML = '<input type="radio" name="ans" id="r4"  value="4">'+escapeHtml(json.message.answer_r)+'</form>';
					}
					i++;
				}
				else
				{
					alert("An error has occured making the request")
				}
			}
		}
		mygetrequest.open("GET", "../../questions/question/"+questions[i], true)
		mygetrequest.setRequestHeader("X-API-Key", "123456")
		mygetrequest.send()
	}
	else
	{
		endGame()
	}
}