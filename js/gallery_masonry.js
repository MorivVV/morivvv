function picrecalc(hdef) {
    let brick = $('.imgblock');
    let brickline = $('.brline');
    let h = 240;
    let wcurr = 0;
    let wmax = $('.wrapper')["0"].scrollWidth;
    if (wmax > $('.wrapper')["0"].clientWidth)
        wmax = $('.wrapper')["0"].clientWidth;
    wmax -= 1;
    let newdiw = 0;
    let nline;
    $(".wrapper").append(brick);
    brickline.remove();
    for (let i = 0; i < brick.length; i++) {
        if (wcurr === 0) {
            newdiw++;
            $(".wrapper").append('<div class="brline" id="brline' + newdiw + '"></dir>');
            nline = $("#brline" + newdiw);
            nline[0].style.display = "block";
        }
        brick[i].style.height = hdef + "px";
        let cW = brick[i].children["0"].clientWidth;
        brick[i].style.height = "";
        nline.append(brick[i]);
        wcurr += cW;
        if (wcurr > wmax) {
            h = hdef * wmax / wcurr;
            nline[0].style.height = h + "px";
            nline[0].style.display = "";
            wcurr = 0;
        }
    }
    h = hdef * wmax / wcurr;
    $("#brline" + newdiw)["0"].style.height = h + "px";
    //$(".brline").css('display','flex');
    //$(".brline").css('justify-content','space-between');
}

function viewPicture(pic) {
    let tumb = pic.firstElementChild.src
    $("#previewimage img")["0"].src = tumb;
    tumb = tumb.match(/tumbs\/([\w\d]+)/i)['1'] + '$';
    $("#previewimage").load(
            "/getPicture/" + tumb);
    $("#previewimage")["0"].style.display = "flex";
    event.stopPropagation();
}
function previewPicture(pic) {
    let tumb = pic.firstElementChild.src
    $("#previewimage img")["0"].src = tumb;
    $("#previewimage")["0"].style.display = "flex";
}
function hidePicture() {
    if (event.target.name == "folder" || event.target.name == "picname")
        return 0;
    $("#previewimage")["0"].style.display = "none";
}
function addGallery(img) {
    let prn = $("select[name=folder]")["0"].selectedOptions["0"];
    let del = 0;
    if (prn.innerText.indexOf("+") === 1) {
        del = 1;
        prn.innerText = prn.innerText.replace(" + ", "")
    }
    let folder = $("select[name=folder]")["0"].value;
    $.ajax({
        url: "/ajax/addGallery.php?id=" + img.alt + "&folder=" + folder + "&del=" + del, // указываем URL и
        success: function (data, textStatus) { // вешаем свой обработчик на функцию success
            prn.innerText = data + prn.innerText;
            if (!del)
                $(".tags").append('<a href="/gallery/brick-' + folder + '">' + prn.innerText + '</a>')
        }
    });
    event.stopPropagation();
}

function multiLoad(event) {
    for (let i = 0; i < event.files.length; i++) {
        let file = event.files[i];
        let form = new FormData();
        form.append("imgupload", file);
        // Создаем запрос
        let xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', uploadProgress, false);
        xhr.onreadystatechange = stateChange;
        xhr.open('POST', '/uploadImage');
        //xhr.setRequestHeader('X-FILE-NAME', file.name);
        xhr.send(form);
    }
    event.value = "";
}
;
// Показываем процент загрузки
function uploadProgress(event) {
    let percent = parseInt(event.loaded / event.total * 100);
    dropZone.text('Загрузка: ' + percent + '%');
}

// Пост обрабочик
function stateChange(event) {
    if (event.target.readyState == 4) {
        if (event.target.status == 200) {
            let ans = $(event.target.responseText).find(".error_log")["0"];
            let an = ans.innerHTML;
            dropZone.text(an);
            console.log(an);
            let tumbsan = /(\w+\.jpg)/.exec(an);
            if (tumbsan !== null) {
                $('.wrapper').prepend('<div class="imgblock" onclick="viewPicture(this)"><img class="imgbrick" src="/image/tumbs/' + tumbsan[0] + '"></div>');
                setTimeout(function () {
                    picrecalc();
                }, 100); // время в мс
            }
            //location.reload();
        } else {
            dropZone.text('Произошла ошибка!');
            dropZone.addClass('error');
        }
    }
}

let dropZone = $('#dropZone'),
        maxFileSize = 10 * 1024 * 1024; // максимальный размер фалйа - 10 мб.    
$(document).ready(function () {

    // Проверка поддержки браузером
    if (typeof (window.FileReader) == 'undefined') {
        dropZone.text('Не поддерживается браузером!');
        dropZone.addClass('error');
    }

    // Добавляем класс hover при наведении
    dropZone[0].ondragover = function () {
        dropZone.addClass('hover');
        return false;
    };

    // Убираем класс hover
    dropZone[0].ondragleave = function () {
        dropZone.removeClass('hover');
        return false;
    };

    // Обрабатываем событие Drop
    dropZone[0].ondrop = function (event) {
        for (let i = 0; i < event.dataTransfer.files.length; i++) {
            event.preventDefault();
            dropZone.removeClass('hover');
            dropZone.addClass('drop');

            let file = event.dataTransfer.files[i];
            // Проверяем размер файла
            if (file.size > maxFileSize) {
                dropZone.text('Файл слишком большой!');
                dropZone.addClass('error');
                return false;
            }
            let form = new FormData();
            form.append("imgupload", file);
            // Создаем запрос
            let xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', uploadProgress, false);
            xhr.onreadystatechange = stateChange;
            xhr.open('POST', '/uploadImage');
            xhr.setRequestHeader('X-FILE-NAME', file.name);
            xhr.send(form);
        }
    };



});