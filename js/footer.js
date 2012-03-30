window.onload = placeFooter();
window.onresize = placeFooter();

function placeFooter() {
	var footer = document.getElementById("footer");
	if(window.innerHeight>footer.offsetTop+footer.scrollHeight) {
		footer.style.position = "absolute";
		footer.style.bottom = "0px";
		footer.style.left = "0px";
	}
	else {
		footer.style.position = "static";
	}
}