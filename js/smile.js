function smileReplace() {
       let tt = $(".trep_text, .text_post, .window-text");
       for (let i=0; i< tt.length; i++) {
           let mid;
            if (tt[i].parentNode.getElementsByClassName("message_number").length>0) {
                mid = tt[i].parentNode.getElementsByClassName("message_number")[0].innerText;
            }
           tt[i].innerHTML = ruleBB(tt[i].innerHTML, mid);
        }
}

function ruleBB(text, mid) {
    text = text.replace(/[\r\n]+/gm, "<BR />");
    text = text.replace(/\*([a-zA-Z]+)(\d+)([a-zA-Z]+)\*/gm, "<img style='max-height: 64px;' src='/image/$1/$2.$3'>");
    text = text.replace(/\[IMG\]([\d\w]{32}\.[\w]{3,4})\[\/IMG\]/gm, '<div onclick="viewPicture(this)" class="picture"><img src="/image/tumbs/$1"></div>');
    text = text.replace(/\[B\]([\s\S]+?)\[\/B\]/gm, '<span style="font-weight: bold;">$1</span>');
    text = text.replace(/\[I\]([\s\S]+?)\[\/I\]/gm, '<span style="font-style: italic;">$1</span>');
    text = text.replace(/\[S\]([\s\S]+?)\[\/S\]/gm, '<span style="text-decoration: line-through;">$1</span>');
    text = text.replace(/\[U\]([\s\S]+?)\[\/U\]/gm, '<span style="text-decoration: underline;">$1</span>');
    text = text.replace(/\[SUP\]([\s\S]+?)\[\/SUP\]/gm, '<span style="vertical-align: super; font-size: smaller;">$1</span>');
    text = text.replace(/\[SUB\]([\s\S]+?)\[\/SUB\]/gm, '<span style="vertical-align: sub; font-size: smaller;: smaller;">$1</span>');
    text = text.replace(/\[URL=(.+?)\]([\s\S]+?)\[\/URL\]/gm, '<a target="_blank" title="$1" href="$1">$2</a>');
    text = text.replace(/\[color=([a-z]+?)\]([\s\S]+?)\[\/color\]/gm, '<span style="color:$1;">$2</span>');
    text = text.replace(/\[SIZE=(\d+?)\]([\s\S]+?)\[\/SIZE\]/gm, '<span style="font-size:$1;">$2</span>');
    text = text.replace(/\[SPOILER=(.+?)\]([\s\S]+?)\[\/SPOILER\]/gm, function (match, head, body, ofset) {return '<span onclick="openSpoiler(' + mid + ofset + ')" class="spoiler_head spoiler_head_close" tabindex="1">' + head + '</span><span id="spoiler' + mid + ofset +'" class="spoiler_content"><div>' + body + '</div></span>'});
    return text;
}

function openSpoiler(num) {
    document.getElementById('spoiler'+num).classList.toggle('active');
}

function smileInsert (smile) {
	var elem =	document.getElementById('posttext');
	var textval = elem.value;
	if (smile.name === "textstyle" && elem.selectionStart!==elem.selectionEnd)
		elem.value = textval.substring(0,elem.selectionStart) + smile.alt.replace("][","]"+textval.substring(elem.selectionStart,elem.selectionEnd)+"[") + textval.substring(elem.selectionEnd);
	else
		elem.value = textval.substring(0,elem.selectionStart) + smile.alt + textval.substring(elem.selectionStart);
}
function loadSmile(el){
	$('#ldsml').load('/getsmile$',{name:el.id,page:el.name});
    }
function quotedPost (post) {
	var elem =	document.getElementById('qanswer');
	elem.value=post.id;
        var elem2 =	document.getElementById('qq');
        elem2.innerHTML = "Ответ на сообщение " + post.id;
        
}
function viewPost (th) {
    var id = th.id;
    if (th.children.length >1)
        0;//th.removeChild(th.children["1"]);
    else
    $.ajax({
  method: "POST",
  dataType: 'json',
  url: "/getPost$",
  data: { post: id },
  success: function(data){
    loadpost( data, th );
  }
});
}
function nextPost (th) {
    var id = th.id;
    $.ajax({
  method: "POST",
  dataType: 'json',
  url: "/getPost$",
  data: { post: id },
  success: function(data){
    loadpost( data, th );
  }
});
    if (th.id === 'null')
        $(th).remove();
}
function loadpost (tr, th) {
    var el = document.createElement('div');
    el.className = 'trep_message';
    var htm = '';
    htm += '<div class="message_head"><div class="message_time">'+tr.TIME_ADD+'</div>';
    htm += '<div class="message_number"><a href="/post'+tr.id_theme+'--'+tr.UID+'-'+tr.ID+'">'+tr.ID+'</a></div></div>';
    htm += '<div class="user_info" >';
    htm += '<div class="user_name"><a style="text-decoration: none" href="/profile/'+tr.USER_NAME+'"><font color="'+tr.color+'" face="Arial">'+tr.USER_NAME+'</font></a></div>';
    htm += '<div class="user_rank"><font color="'+tr.color+'" face="Arial">'+tr.RANK+'</font></div></div>';
    htm += '<div class="trep_text"' ;
    if (tr.LAST_ACTIVE < 500) 
        htm += ' style="background-image: url(/image/system/icon_user_online.gif)"';
    htm += '>' ;
    if (tr.KOD_QUOTED_POST>0)
        htm += '<div onclick="viewPost(this)" id="'+tr.KOD_QUOTED_POST+'" class="message-quoted"><a>'+tr.KOD_QUOTED_POST+' от '+tr.quser+'</a>  </div>'  ;    
    htm += tr.POST+'</div>' ;     
    el.innerHTML = htm;
    th.parentElement.insertBefore(el, th);
    th.id = tr.nextPo;
}
function deletePost (id) {
	if (confirm("Пост будет удален")) {
		var del = id.alt;
		var post = id.parentNode.parentNode;
		$(post).load("/delPost$",{post: del});
	}
}
function changePost (id) {
	var change = id.alt
	id.src = "/image/system/save.png"
	id.onclick=function(){savePost(this)}
	var post = id.parentNode.parentNode.nextElementSibling.nextElementSibling
	$(post).load("/changePost$",{post: change});
        
}
function savePost (id) {
	var change = id.alt;
	id.src = "/image/system/pen.png";
	id.onclick=function(){changePost(this);};
	var post = id.parentNode.parentNode.nextElementSibling.nextElementSibling;
	$.ajax({
	      method: "POST", // метод HTTP, используемый для запроса
	      url: "/savePost$", // строка, содержащая URL адрес, на который отправляется запрос
	      data: { // данные, которые будут отправлены на сервер
	        "post": change , 
                "text": post.getElementsByTagName("textarea")["0"].value
	      },
        success: function () {
            post.innerHTML = ruleBB(post.getElementsByTagName("textarea")["0"].value);
        }
        });
        }
document.addEventListener("DOMContentLoaded", smileReplace);