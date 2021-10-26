var razm = 35;
var step;
var potok = 600;
var position = [{x: 500, y: 10, color: "$ffffff"}];
var example = document.getElementById("example");
var ctx = example.getContext('2d');
var ctxm = example.getContext('2d');
var speed = 5;
var uscor = 10;
var machine = {w: 250, h: 80};
ctx.strokeStyle = '#ff00ff';
addEventListener("keydown", PressKey);
addEventListener('touchstart', function (e) {
    var touchobj = e.changedTouches[0] // первая точка прикосновения
    startx = parseInt(touchobj.clientX) // положение точки касания по x, относительно левого края браузера
    starty = parseInt(touchobj.clientY)
    //e.preventDefault()
}, false)

addEventListener('touchmove', function (e) {
    var touchobj = e.changedTouches[0] // первая точка прикосновения для данного события
    var distx = parseInt(touchobj.clientX) - startx
    var disty = parseInt(touchobj.clientY) - starty
    var tou = (Math.abs(distx) < Math.abs(disty)) * 2
    if (tou > 0)
        tou += (disty > 0)
    else
        tou += (distx > 0)
    switch (tou) {
        case 0://лево
            step = 37
            break;
        case 1://право
            step = 39
            break;
        case 2://вверх
            step = 38
            break;
        case 3://вниз
            step = 40
            break;
        default:
            step = 65
            break;
    }
    //e.preventDefault()
}, false)
gowall(400);
function gowall(ofset) {
    ctx.fillStyle = '#333333';
    ctx.fillRect(0, 0, example.width, example.height);
    if (ofset === 0) {
        ofset = razm * 2 * speed;
        brick();
    }
    var i = 8;
    for (var j = -10; j < 40; j += 2 * speed) {
        ctx.clearRect(j * razm + ofset, i * razm, razm * 3, razm);
    }
    for (var i = 1; i < position.length; i++) {
        ctx.fillStyle = position[i].color;
        ctx.fillRect(position[i].y, position[i].x, machine.w, machine.h);
        ctx.strokeRect(position[i].y, position[i].x, machine.w, machine.h);
        ctx.strokeRect(position[i].y + 55, position[i].x, machine.h, machine.h);
        ctx.strokeRect(position[i].y + 40, position[i].x, machine.w * 0.6, machine.h);
        position[i].y--;
    }
    ctx.fillStyle = '#ffff00';
    ctx.fillRect(position[0].y, position[0].x, machine.w, machine.h);
    ctx.strokeRect(position[0].y, position[0].x, machine.w, machine.h);
    ctx.strokeRect(position[0].y + 55, position[0].x, machine.h, machine.h);
    ctx.strokeRect(position[0].y + 40, position[0].x, machine.w * 0.6, machine.h);
    if (crush() === false)
        setTimeout(gowall, uscor, ofset - speed);
}
function PressKey(e) {
    step = e.keyCode;
    switch (step) {
        case 37://лево
        case 65://A
            uscor += 1
            if (uscor > 20)
                uscor = 20;
            position[0].y -= speed;
            if (position[0].y < 0)
                position[0].y = 0;
            break;
        case 38://вверх
        case 87://W
            position[0].x -= speed;
            if (position[0].x < 0)
                position[0].x = 0;
            break;
        case 39://право
        case 68://D
            uscor -= 1
            if (uscor < 1)
                uscor = 1;
            position[0].y += speed;
            if (position[0].y > 700)
                position[0].y = 700;
            break;
        case 40://вниз
        case 83://S
            position[0].x += speed;
            if (position[0].x > 520)
                position[0].x = 520;
            break;
        default:
            break;
    }
}
function brick() {
    var x;
    var y = 1200;
    if (position.length > 1 && position[1].y < -machine.w)
        position.splice(1, 1)
    x = Math.floor(Math.random() * (510 - 290) + 290);
    if (position.length < 4 && position[position.length - 1].y < potok) {
        position.push({x: x, y: y, color: randomColor()});
        potok += 5
    }
}
function crush() {
    for (var i = 1; i < position.length; i++) {
        if (intersects(position[0], position[i]))
            return true;
    }
    return false;
}
function intersects(a, b) {
    return (Math.abs(a.x - b.x) < machine.h && Math.abs(a.y - b.y) < machine.w)
}
function randomColor() {
    var allowed = "ABCDEF0123456789", S = "#";

    while (S.length < 7) {
        S += allowed.charAt(Math.floor((Math.random() * 16) + 1));
    }
    return S;
}
