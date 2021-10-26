function addFolder (obj) {
	var nfolder = prompt("Введите название новой папки для галлереи");
        var gal = document.location.pathname;
        if (gal.indexOf("-")!=-1) {
            gal = gal.substr(8,(gal.indexOf("-")-8)); }
        else{
            gal = gal.substr(8);
        }
        console.log(gal);   
	if (nfolder){
		$(obj).load("/ajax/addFolder.php",{folder: nfolder}, function(response, status) {
		$(obj.parentElement).append('<a href="/gallery'+gal +'-'+response+'">'+nfolder+'</a>');})
	}
}

function seleltimgage(id){
	var tbody = id.parentNode.parentNode.parentNode;
	if (document.getElementById("previewimg")){
		var elem = document.getElementById("previewimg");
		tbody.removeChild(elem);
	}
	var row = document.createElement("TR");
	row.id = "previewimg"
	var frm = document.createElement("FORM");
	frm.method = "post";
	frm.style.height = 13;
	frm.action = "/index.php?url=gallery";
	var delval = document.createElement("INPUT");
	delval.name="imgname";
	delval.hidden = true;
	delval.value = id.alt;
	var delbut = document.createElement("INPUT");
	delbut.type="submit"; 
	delbut.value="Удалить фото";
	delbut.style.width= "100%";
	delbut.style.height = 25;
	delbut.style.marginTop = 2;
	var td1 = document.createElement("TD");
	td1.colSpan = 5;
	var ha = document.createElement("A");
	ha.href = "/image/"+id.alt;
	ha.target="_blank";
	ha.value = id.alt;
	var img1 = document.createElement("IMG");
	img1.src ="/img.php?img="+id.alt+"&"+id.title;
	img1.style.width= "100%";
	frm.appendChild(delval);
	frm.appendChild(delbut);
	ha.appendChild(img1);
	td1.appendChild(ha);
	td1.appendChild(frm);
	row.appendChild(td1);
	var i =id.parentNode.parentNode.sectionRowIndex;
	tbody.insertBefore(row,tbody.children[i+1]);
  }
  function multiLoad(event) {
      var newFileList = Array.from(event.files);
        for (var i = 0; i < event.files.length; i++) {
         var file =   event.files[i];                 
        var form = new FormData();
        form.append("imgupload", file);
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', uploadProgress, false);
        xhr.onreadystatechange = stateChange;
        xhr.open('POST', '/uploadImage');
        //xhr.setRequestHeader('X-FILE-NAME', file.name);
        xhr.send(form);
        newFileList.splice(i,1);
    }
    
    };
        // Пост обрабочик
    function stateChange(event) {
        if (event.target.readyState == 4) {
            if (event.target.status == 200) {
                var ans = $(event.target.responseText).find(".error_log")["0"];
                dropZone.text(ans.innerHTML);
                console.log(ans.innerHTML);
                //location.reload();
            } else {
                dropZone.text('Произошла ошибка!');
                dropZone.addClass('error');
            }
        }
    } 
    // Показываем процент загрузки
    function uploadProgress(event) {
        var percent = parseInt(event.loaded / event.total * 100);
        dropZone.text('Загрузка: ' + percent + '%');
    } 
  $(document).ready(function() {
    
    var dropZone = $('#dropZone'),
        maxFileSize = 10*1024*1024; // максимальный размер фалйа - 10 мб.
    
    // Проверка поддержки браузером
    if (typeof(window.FileReader) == 'undefined') {
        dropZone.text('Не поддерживается браузером!');
        dropZone.addClass('error');
    }
    
    // Добавляем класс hover при наведении
    dropZone[0].ondragover = function() {
        dropZone.addClass('hover');
        return false;
    };
    
    // Убираем класс hover
    dropZone[0].ondragleave = function() {
        dropZone.removeClass('hover');
        return false;
    };
    
    // Обрабатываем событие Drop
    dropZone[0].ondrop = function(event) {
        for (var i = 0; i < event.dataTransfer.files.length; i++) {
        event.preventDefault();
        dropZone.removeClass('hover');
        dropZone.addClass('drop');
          var file =   event.dataTransfer.files[i];                 
        // Проверяем размер файла
        if (file.size > maxFileSize) {
            dropZone.text('Файл слишком большой!');
            dropZone.addClass('error');
            return false;
        }
        var form = new FormData();
        form.append("imgupload", file);
        // Создаем запрос
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', uploadProgress, false);
        xhr.onreadystatechange = stateChange;
        xhr.open('POST', '/uploadImage');
        xhr.setRequestHeader('X-FILE-NAME', file.name);
        xhr.send(form);
    }
    };
    

    

    
});