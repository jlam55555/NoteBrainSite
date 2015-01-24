var search, char_count, request;

$(document).ready(function() {
	/*
	 *	These two functions, search() and char_count(), are called on every key press
	 */
	search = function(query) {
		
		// Add code to search notes here later
		
	}
	// To count the number of characters (up to 500).
	char_count = function (query) {
		
		var elem = document.getElementById("char_count");
		
		if(query.length < 3)
			elem.innerHTML = 3-query.length + " more characters to submit.";
		else
			elem.innerHTML = 500-query.length + " characters left.";
		
	}
	
	// request() is called on the change of the select elementFromPoint, and on load
	request = function() {
		
        $.ajax({
            type: "GET",
            cache: false,
            url: "res/get_tree.php",
            data: "id=" + $("select[name=folders]").val() + "&nested=" + $("#nested").is(":checked"),
            success: function(msg) {
				$("#notes").html(msg);
            }
        });
		
	}
	request();
	
    $("form[id=create_note]").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            cache: false,
            url: "ver/create.php",
            data: "note=" + $("input[name=note]").val() + "&folder_id=" + $("select[name=folders]").val(),
            success: function(msg) {
				request(1,false);
            }
        });
    });     
});         