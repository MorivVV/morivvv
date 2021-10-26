$(".answer").click(function(){
	var temp = this;
	var num = temp.innerHTML;
	temp.innerHTML = $("#basic-insert")["0"].outerHTML;
	temp.childNodes.item(0).id="";
	temp.childNodes.item(0).name=this.id;
	$(temp).find("#num-"+num).css("color", "red");
})
$(document).on("click",".sudo-numer",function(event){
	var temp = this.parentElement.parentElement.parentElement.name;
	if (checkNum(temp.substr(5),this.innerHTML)) 
		$("#" +temp)["0"].innerHTML = "<span style='color:red; font-weight:bold;'>"+this.innerHTML+"</span>";
	else
		$("#" +temp)["0"].innerHTML = "<span style='color:green;'>"+this.innerHTML+"</span>";
})

function checkNum(id, num){
	var scanX = (id-1) % 9;
	var scanY = div((id-1),9);
	for (var i = 1; i <= 9; i++) {
		var viewnum = $("#sudo-" + (+scanY*9 + i))["0"].innerHTML;
		if (viewnum == num) {
			return true;
		}
	}
	for (var i = 0; i < 9; i++) {
		var viewnum = $("#sudo-" + (+scanX + i*9 + 1))["0"].innerHTML;
		if (viewnum == num) {
			return true;
		}
	}
	for (var i = 0; i <= 2; i++) 
		for (var ii = 1; ii <= 3; ii++) {
			var viewnum = $("#sudo-" + ((scanY-scanY%3+i)*9+ (scanX-scanX%3) + ii))["0"].innerHTML;
			if (viewnum == num) return true;
		}
			
	return false;
}
function div(val, by){
    return (val - val % by) / by;
}