window.onload = placeFooter();
window.onresize = placeFooter();

function placeFooter() {
	var footer = document.getElementById("bottom");
	console.log(window.innerHeight+" "+(footer.offsetTop+footer.scrollHeight));
	if(window.innerHeight>footer.offsetTop+footer.scrollHeight) {
		footer.style.position = "absolute";
		footer.style.left = "0px";
	}
	else {
		footer.style.position = "relative";
	}
}