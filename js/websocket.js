$('#sendws').click(function(){
    $.post('/sendmsg$', { 'sender': welcomeuser.children[1].childNodes[3].innerText 
                        , 'receiver': user.value
                        , 'chat': chat.value
                        , 'message': message.value});
    let now = new Date();
    //document.getElementById("ws-chat").innerHTML += welcomeuser.children[1].childNodes[3].innerText + '->' +$('input[name="user"]')[0].value + "(" + (now + "): " + $('input[name="message"]')[0].value +"<br />");
    message.value = '';
})

ws = new WebSocket("wss://morivvv.ru:8080/?user="+welcomeuser.children[1].childNodes[3].innerText + '&chat=' + chat.value);
ws.onopen = connectionOpen;
ws.onmessage = messageReceived;
ws.onclose = connectionClose;

function connectionOpen() {
    document.getElementById("connect").innerHTML = "Вы подключены к чату";
    document.getElementById("connect").setAttribute('class','online');
}
function connectionClose() {
    document.getElementById("connect").innerHTML = "Вы отключены";
    document.getElementById("connect").setAttribute('class','offline');
}

function messageReceived(e) {
    //console.log("Ответ сервера: " + e.data);
        let data = JSON.parse(e.data);
        let now = new Date();
        document.getElementById("ws-chat").innerHTML += (now.toLocaleTimeString() + "  <b>"+ data.sender + ":</b> "  + data.message+"<br />");
        player.play();
        //document.getElementById("ws-chat").scrollTop = document.getElementById("ws-chat").scrollHeight;
}
