function AddQuery(sqlq) {
	var textarea =	document.getElementById('qstr');
	textarea.value = sqlq.name;
	document.getElementById('sumb').submit();
}

function CreateQueryInsert(table){
var into ="";
var val ="";
var linetr = document.getElementById('add');
var elems = linetr.getElementsByTagName('input');
for(var i=0; i<elems.length; i++) { 
	if (elems[i].name!="" && elems[i].value!="") {
		into = into + "`"+ elems[i].name+"`,";
		val = val +"'"+ elems[i].value+"',";
	}
}
into=into.substr(0, into.length - 1);
val=val.substr(0, val.length - 1);
var textarea =	document.getElementById('qstr');
textarea.value = "INSERT INTO "+table+" ("+into+") VALUE ("+val+")";
document.getElementById('table_save').value =table;
document.getElementById('sumb').submit();
}

function CreateQueryUpdate(id, table){
var setval ="";
var where ="";
var linetr = document.getElementById(id);
var elems = linetr.getElementsByTagName('input');
var elem = linetr.getElementsByTagName('span');
for(var i=0; i<elems.length; i++) { 
	if (elems[i].name!="" && elems[i].value!="") {
		var sname = elems[i].title;
		var sID =elems[i].name;
		if (sname!=elems[i].value)
			setval = setval + " `"+ sID+"`="+"'"+ elems[i].value+"',";
	}
}
setval=setval.substr(0, setval.length - 1);
where = elem[0].attributes.name.value+'='+ elem[0].innerText;
var textarea =	document.getElementById('qstr');
textarea.value = "UPDATE " +table+" SET "+setval+" WHERE "+where;
document.getElementById('table_save').value =table;
RunSQL(textarea.value);
}

function CreateQueryDelete(id,table){
var setval ="";
var where ="";
var linetr = document.getElementById(id);
var elems = linetr.getElementsByTagName('span');
where = elems[0].attributes.name.value+'='+ elems[0].innerText;
var textarea =	document.getElementById('qstr');
textarea.value = "DELETE FROM "+table+" WHERE "+where;
document.getElementById('table_save').value =table;
document.getElementById('sumb').submit();
}