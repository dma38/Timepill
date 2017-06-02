function addComment()
{
	document.getElementById("addComment").style.display = "block";
}

function load()
{
	document.getElementById("addComment").style.display = "none";
    document.getElementById("postComment").addEventListener("click",addComment,false);
}



document.addEventListener("DOMContentLoaded", load);