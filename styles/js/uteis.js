var modal = document.getElementById("modal");
var btnmodal = document.getElementById("btnmodal")
var btnfechar = document.getElementById("btnclose")
var btnfinalizar = document.getElementById("btnfinalizar")

btnmodal.onclick = function() { modal.style.display = "block" }
btnfechar.onclick = function() { modal.style.display = "none" }

window.onclick = function(event) {
	if (event.target == modal) {
    	modal.style.display = "none";
	}
} 