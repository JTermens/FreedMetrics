<?php

// Advanced search is only available for registered users
if (!isset($_SESSION['username'])) {
	header("Location: index.php?pagename=Home");
}

$header = "Error";
$subheader = "Sorry, seems that something went wrong.";
$title = "FreedMetrics - Advanced Search";

print(page_head($_SESSION['pagename'],$title));
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

	var count = 2;

  $("#append").click(function(){
    $("#form-group").append("<div class=\"row\" id=\"row"+count+"\"><div class=\"col-2\"><select class=\"adv_select\" name=\"connector"+count+"\"><option value=\"AND\">AND</option><option value=\"OR\">OR</option><option value=\"NOT\">NOT</option></select></div><div class=\"col-6\"><div class=\"adv_input_box\"><input class=\"adv_input\" type=\"text\" name=\"search_input"+count+"\" placeholder=\"Enter the text to search\"></input></div></div><div class=\"col-3\"><select class=\"adv_select\" name=\"field"+count+"\"><option value=\"all\">all</option><option value=\"title\">title</option><option value=\"author\">author</option><option value=\"abstract\">abstract</option><option value=\"journal\">journal</option><option value=\"keyword\">keyword</option><option value=\"source_id\">source id</option><option value=\"doi\">doi</option></select><span><button class=\"circ-btn minusSign\" type=\"button\" onclick=\"remove('row"+count+"')\">&minus;</button></span></div></div>");

    count++;
  });
});

function remove(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
  }
</script>

<!-- Main Content -->
<div class="container">
	<div class="card border-0 shadow my-5 col-lg-8 col-md-10 mx-auto">
		<div class="card-body p-5">
			<div class="container">
		    	<div class="row justify-content-center">
		        	<div class="col-12 text-center">
		          		<h2 class="text-black mt-0">Advanced Search Tool</h2>
		          		<hr class="divider">
		          		<p class="text-black-20 mb-4">Use this <b>Advanced Search tool</b> to build complex queries and refine your search. Select a field for your search and add rows to refine and exapand your query.</p>
		          		<div class="row">
		          			<div class="col-8">
		          			</div>
		          			<div class="col-3">
		          				<p style="font-weight: bold; color: var(--color3);">Field</p>
		          			</div>
		        			</div>
		          		<form action="index.php?pagename=Search-Results&action=new" id="search_query" name="search_query" method="POST" enctype="multipart/form-data">
		          			<div class="form-group" id="form-group">
		          				<div class="row" id="row1">
			          				<div class="col-2">
			          				</div>
			          				<div class="col-6">
			          					<div class="adv_input_box">
			          						<input class="adv_input" type="text" name="search_input1" placeholder="Enter the text to search"></input>
			          					</div>
			          				</div>
			          				<div class="col-3">		          					
				          				<select class="adv_select" name="field1">
				          					<option value="all">all</option>
				          					<option value="title">title</option>
				          					<option value="author">author</option>
				          					<option value="abstract">abstract</option>
				          					<option value="journal">journal</option>
				          					<option value="keyword">keyword</option>
				          					<option value="source_id">source id</option>
				          					<option value="doi">doi</option>
							             </select>     
			          				</div>			        					
			          			</div>
		          			</div>
		          			<div class="row">
		          				<div class="col-4">			          				
		          					<button type="button" id="append" class="adv_select">Add row</button>
		          				</div>
		          			</div>
		          			<br>
		          			<div class="row justify-content-center">
		          				<button type="submit" class="btn btn-primary">Submit qury</button>
		          			</div>
      					</form>
		          </div>
		        </div>
		    </div>
		</div>
	</div>
</div>

<?php print(page_footer($_SESSION['pagename']));