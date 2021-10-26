/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
let conn = false;
jQuery(document).ready (function() {
    if (document.cookie.indexOf("HASHIP") >= 0){
    wsconnect();
    document.getElementById("message").onkeypress = sendMessage;
    jQuery(".text_post").on("click",selectAnswer);
}
})

function selectAnswer () {
       let tp = jQuery(".text_post");
       for (i=0;i<tp.length;i++) {
           tp[i].setAttribute('class', 'text_post');
       }
       this.setAttribute('class', 'text_post user_online');
    }
function wsconnect() {
    if (conn) return;
    let ws = new WebSocket("wss://morivvv.ru:8080");
    ws.onopen = connectionOpen;
    ws.onmessage = messageReceived;
    ws.onclose = connectionClose;
}
function connectionOpen() {
    //document.getElementById("blink").innerHTML = "Вы подключены к чату";
    document.getElementById("blink").setAttribute('class', 'user_online');
    conn = true
}
function connectionClose() {
    //document.getElementById("blink").innerHTML = "Вы отключены";
    conn = false
    document.getElementById("blink").setAttribute('class', 'user_offline');
    setTimeout(wsconnect(), 5000);
}
function messageReceived(e) {
    //console.log("Ответ сервера: " + e.data);
    let data = JSON.parse(e.data);
    let now = new Date();
    ++document.getElementById("blink").innerHTML;
    let last = jQuery(".author_post").last()[0].innerText;
    let newMsg = '<div class="private_post next">\n\ ' 
    if (data.sender !== last) {
    newMsg += '<a class="author_post" href="/profile/' + data.sender + '">' + data.sender + '</a>\n\ '} 
    newMsg += '<span class="time_post">' + now.toLocaleTimeString() + '</span>\n\
<span title="' + data.sender + '" class="text_post">'+ data.message +'</span> \n\
</div>';
    document.getElementById("user_message").innerHTML += newMsg
    player.play();
    document.getElementsByClassName("private_message")[0].scrollTop = document.getElementsByClassName("private_message")[0].scrollHeight;
    jQuery(".text_post").on("click",selectAnswer);
}
function sendMessage(e){
    if(e.which != 13) {return true;}
    let uto;
    let now = new Date();
    
    if (document.getElementsByClassName('text_post user_online').length == 0 ) {
        uto = jQuery(".author_post").last()[0].innerText;
    }else{
        uto = document.getElementsByClassName('text_post user_online')[0].title;
        }
    jQuery.post('/sendmessage$', { 'theme': "websocket"
                        , 'timenow' : 0
                        , 'user_to': uto
                        , 'POST': message.value});
    let last = jQuery(".author_post").last()[0].innerText;
    let newMsg = '<div class="private_post next">\n\ ' 
    if (welcomeuser.children[1].childNodes[3].innerText !== last) {
    newMsg += '<a class="author_post" href="/profile/' + welcomeuser.children[1].childNodes[3].innerText + '">' + welcomeuser.children[1].childNodes[3].innerText + '</a>\n\ ';}
    newMsg += '<span class="time_post">' + now.toLocaleTimeString() + '</span>\n\
<span title="' + welcomeuser.children[1].childNodes[3].innerText + '" class="text_post">'+ message.value +'</span> \n\
</div>';
    document.getElementById("user_message").innerHTML += newMsg;
    message.value = "";
    document.getElementsByClassName("private_message")[0].scrollTop = document.getElementsByClassName("private_message")[0].scrollHeight;
    jQuery(".text_post").on("click",selectAnswer);
}