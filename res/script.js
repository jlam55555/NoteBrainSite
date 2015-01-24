/*
 *	These two functions, search() and char_count(), are called on every key press
 */
function search(query) {
	
	// Add code to search notes here later
	
}

// To count the number of characters (up to 500).
function char_count(query) {
	
	var elem = document.getElementById("char_count");
	
	if(query.length < 3)
		elem.innerHTML = 3-query.length + " more characters to submit.";
	else
		elem.innerHTML = 500-query.length + " characters left.";
	
}

// request() is called on the change of the select elementFromPoint, and on load
function request(id,nested) {
	
	// Send HTTPRequest to php to get file tree of notes
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET","res/get_tree.php?id=" + id + "&nested=" + nested,true);
	xmlhttp.send();
	
	// Print out output
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
			document.getElementById("notes").innerHTML = xmlhttp.responseText;
	}
	
}
request(1,false);