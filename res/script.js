// Setting methods so that they aren't undefined.
var search, char_count, request, select, del, del_user;

$(document).ready(function() {
	/*
	 *	These two functions, search() and char_count(), are called on every key press
	 */
	search = function(query) {
		
		// Add code to search notes here later
		
	}
	// To count the number of characters (up to 500).
	char_count = function(query) {
		
		var elem = document.getElementById("char_count");
		
		if(query.length < 3)
			elem.innerHTML = 3-query.length + " more characters to submit.";
		else
			elem.innerHTML = 500-query.length + " characters left.";
		
	}
	
	// request() is called on the change of the select element, and on load
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
	
	// select() is called on creation of folder, and on load
	select = function(to_select) {
		$.ajax({
			type: "POST",
			cache: false,
			url: "part/select_folder.php",
			data: "",
			success: function(msg) {
				$("#folders").html(msg);
				$("option:selected").removeAttr("selected");
				$("option[value=" + to_select + "]").attr("selected","selected");
				request();
			}
		});
	}
	select(1);
	
	// Call this to create note/folder asynchronously
    $("form[id=create]").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            cache: false,
            url: "ver/create.php",
            data: "note=" + $("input[name=note]").val() + "&folder_id=" + $("select[name=folders]").val() + "&type=" + $("input:radio[name=type]:checked").val(),
            success: function(msg) {
				request();
				if($("input:radio[name=type]:checked").val() == "folder")
					select(msg);
            }
        });
    });

	// Call this to create note/folder asynchronously
    $("input[type=radio][name=type]").change(function(e) {
		var type = $(this).val();
		$(".to_change").each(function() {
			$(this).html(type);
		});
    });
	
	del = function(id) {
		$.ajax({
            type: "POST",
            cache: false,
            url: "ver/delete.php",
            data: "id=" + id,
            success: function(msg) {
				request();
            }
        });
	}
	
	// Call this function to verify the user password before deleting an account
	del_user = function() {
		if(!confirm("Are you sure you want to delete this user?") || $("#delete_verification").val() == "")
			return;
		$.ajax({
            type: "POST",
            cache: false,
            url: "ver/delete_user.php",
            data: "pass=" + $("#delete_verification").val(),
            success: function(msg) {
				if(msg == "true")
					window.location = "res/signout.php";
				else
					alert("Password was incorrect.");
            }
        });
	}
	
});