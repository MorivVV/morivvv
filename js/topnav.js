var h_hght = 100; // высота шапки
var h_mrg = 0;    // отступ когда шапка уже не видна
var s_top = 0;
function openMenu() {
    document.getElementById('main_sidebar').classList.toggle('active');
}
function openMessage() {
    document.getElementsByClassName('private_message')[0].classList.toggle('active');
}
function agent(v) {
    return(Math.max(navigator.userAgent.toLowerCase().indexOf(v), 0));
}
function xy(e, v) {
    return(v ? (agent('msie') ? event.clientY + document.body.scrollTop : e.pageY) : (agent('msie') ? event.clientX + document.body.scrollTop : e.pageX));
}
function dragOBJ(d, e) {
    function drag(e) {
        if (!stop) {
            d.style.top = (tX = xy(e, 1) + oY - eY + 'px');
            d.style.left = (tY = xy(e) + oX - eX + 'px');
        }
    }
    var oX = parseInt(d.style.left), oY = parseInt(d.style.top), eX = xy(e), eY = xy(e, 1), tX, tY, stop;
    document.onmousemove = drag;
    document.onmouseup = function () {
        stop = 1;
        document.onmousemove = '';
        document.onmouseup = '';
    };
}
$(document).on('click', '.menu', function () {
    $(".top_table ul").toggle("slow");
});
function ScanerChange(checkbox) {
    if (checkbox.value == '1')
        checkbox.value = '0';
    else
        checkbox.value = '1';
}

function myFetch(params){
    return new Promise(function(resolve, reject){
       const xhr = new XMLHttpRequest();
        xhr.open(params.method, params.url, true);
        xhr.send();
        xhr.addEventListener('readystatechange', function(e){
              if( xhr.readyState != 4  ) return;
              if( xhr.status == 200 ){
                   resolve( xhr.responseText );
               } else{ 
                   reject( xhr.statusText ); 
               }
        });
    })
}

if (!Array.prototype.find) {
 Object.defineProperty(Array.prototype, 'find', {
 value: function(predicate) {
 // 1. Let O be ? ToObject(this value).
 if (this == null) {
 throw new TypeError('"this" is null or not defined');
 }
 var o = Object(this);
 // 2. Let len be ? ToLength(? Get(O, "length")).
 var len = o.length >>> 0;
 // 3. If IsCallable(predicate) is false, throw a TypeError exception.
 if (typeof predicate !== 'function') {
 throw new TypeError('predicate must be a function');
 }
 // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
 var thisArg = arguments[1];
 // 5. Let k be 0.
 var k = 0;
 // 6. Repeat, while k < len
 while (k < len) {
 // a. Let Pk be ! ToString(k).
 // b. Let kValue be ? Get(O, Pk).
 // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
 // d. If testResult is true, return kValue.
 var kValue = o[k];
 if (predicate.call(thisArg, kValue, k, o)) {
 return kValue;
 }
 // e. Increase k by 1.
 k++;
 }
 // 7. Return undefined.
 return undefined;
 }
 });
}