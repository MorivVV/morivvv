/* global machine */

let obj = document.getElementById("cnv"),
        cnv = obj.getContext('2d');
let blockSize = 32;
let pixelOnBlock = 8;
obj.width = 26*blockSize;
obj.height = 26*blockSize;
let wave = true;
let track = true;
let player1 = {x:blockSize*9, y:blockSize*24, move:0};
let enemyTank = [[0,0],[blockSize*10,0]];
let pulya = {x:-blockSize*2, y:-blockSize*2, move:0};
cnv.strokeStyle = 'white';
let map = JSON.parse(cnv.canvas.attributes[1].value);
addEventListener("keydown", PressKey);
starmove();
//обновление карты
let timerId = setInterval(() => starmove(), 50);
//анимация волн
let waveId = setInterval(() => newpos(), 800);
//анимация пули
let bulletId = setInterval(() => movePule(), 20);

function newpos(){
    wave = !wave;
}

function starmove() {
    cnv.clearRect(0, 0, obj.width, obj.height);
    for (let o = 0; o < 26; o++)
        for (let m = 0; m < 26; m++)
            switch (map[m][o]) {
                case 0:
                    changePos(blackBlock, o, m);
                    break;
                case 1:
                    changePos(brickBlock, o, m);
                    break;
                case 2:
                    changePos(betonBlock, o, m);
                    break;
                case 3:
                    changePos(greenBlock, o, m);
                    break;
                case 4:
                    if (wave) {
                        changePos(waterBlock, o, m);
                    } else{  
                        changePos(waterBlock2, o, m);
                    }
                    break;
                case 5:
                    changePos(iceBlock, o, m);
                    break;
                case 8:
                    eagleBlock(blockSize * o, blockSize * m);
                    break;    
                default:
                    break;
            }
    changePos(enemyTankLight,player1.x/blockSize,player1.y/blockSize,player1.move);
    changePos(tank,0,0,90);
    changePos(tank,12,0,180);
    changePos(tank,24,0,270);
    changePos(bullet,pulya.x/blockSize,pulya.y/blockSize,pulya.move);
}
function setOfset(grad){
    let ofsetx = 0, ofsety = 0;
    switch (grad) {
        case 0:
            ofsetx = 0; ofsety = 0;
            break;
        case 90:
            ofsetx = 2*blockSize; ofsety = 0;
            break;
        case 180:
            ofsetx = 2*blockSize; ofsety = 2*blockSize;
            break;
        case 270:
            ofsetx = 0; ofsety = 2*blockSize;
            break;
    }
    return {x:ofsetx, y:ofsety}
}
//смещение блока
function changePos(func,x,y,grad=0){
    let ofset;
    ofset=setOfset(grad);
    cnv.translate(x*blockSize+ofset.x,y*blockSize+ofset.y);
    cnv.rotate(Number(grad) * Math.PI / 180);
    func();
    cnv.rotate(Number(-grad) * Math.PI / 180);
    cnv.translate(-x*blockSize-ofset.x,-y*blockSize-ofset.y);
}
//отрисовка массива пиксетелй
function rmass(mass) {
    for (let i = 0; i < mass.length; i++) {
       fr(mass[i][0],mass[i][1],1,1);
    }
}
//отрисовка одного игрового пикселя
function fr(x,y,wei,hei,color='') {
    if (color !==''){
        cnv.fillStyle = color;
    }
    cnv.fillRect(x * blockSize/pixelOnBlock, y * blockSize/pixelOnBlock, wei * blockSize/pixelOnBlock, hei * blockSize/pixelOnBlock);
}
function blackBlock() {
    fr(0, 0, 8, 8,'black');
}
function brickBlock() {
    fr(0, 0, 8, 8,'#606060');
    fr(0, 0, 7, 3,'#5A0302');
    fr(0, 4, 4, 3);
    fr(5, 4, 3, 3);
    fr(1, 1, 6, 2,'#A64010');
    fr(0, 5, 4, 2);
    fr(6, 5, 2, 2);
}
function betonBlock() {
    fr(0, 0, 8, 8,'#606060');
    cnv.fillStyle = '#C4C4C4'
    cnv.beginPath();
    cnv.moveTo(0, blockSize);
    cnv.lineTo(blockSize, 0);
    cnv.lineTo(0, 0);
    cnv.closePath();
    cnv.fill();
    fr(2, 2, 4, 4,'#F0F0F0');
}
function greenBlock() { 
    fr(0, 0, 8, 8,'#66D000');
    cnv.fillStyle = '#003400'
    cnv.beginPath();
    cnv.moveTo(0, blockSize);
    cnv.lineTo(blockSize, 0);
    cnv.lineTo(0, 0);
    cnv.closePath();
    cnv.fill();
    rmass([[3,7],[5,6],[3,4],[7,4],[5,3],[6,3],[6,1]]);
    cnv.fillStyle = '#66D000';
    rmass([[6,0],[3,1],[2,4],[5,1],[5,2],[3,3],[4,3],[0,6],[1,6]]);
    cnv.fillStyle = 'black';
    rmass([[0,0],[0,7],[7,0],[7,7]]);
}
function waterBlock() {
    fr(0, 0, 8, 8,'#301FFC');
    cnv.fillStyle = '#9EEFEF'
    rmass([[7,0],[1,1],[2,2],[3,3],[6,3],[7,4],[3,5],[2,6],[4,6],[0,7]]);
}
function waterBlock2() {
    fr(0, 0, 8, 8,'#301FFC');
    cnv.fillStyle = '#9EEFEF'
    rmass([[0,2],[1,3],[1,6],[2,7],[3,4],[4,3],[5,0],[5,4],[6,7]]);
}
function iceBlock(){
    fr(0, 0, 8, 8,'silver');
    cnv.fillStyle = 'white'
    rmass([[0,7],[1,6],[2,5],[3,4],[4,3],[5,2],[6,1],[7,0],[3,0],[0,3],[4,7],[5,6],[6,5],[7,4]]);
    cnv.fillStyle = 'gray';
    rmass([[1,7],[2,6],[3,5],[4,4],[5,3],[6,2],[7,1],[0,0],[4,0],[0,4],[5,7],[6,6],[7,5]]);
}

function tank() {
    let tmp = [];   
    fr(1, 5, 13, 11,'#ECEC92');
    fr(5, 6, 6, 9, '#D09030');
    for (let i = 5; i < 16; i+=2) {
        tmp.push([2,i],[12,i],[13,i]);
    }
    tmp.push([3,5],[3,15]); 
    rmass(tmp);
    fr(4, 14, 7, 2,'black');
    fr(4, 5, 7, 2);
    rmass([[4,7],[10,7]]);
    fr(11, 6, 1, 10,'#6F6100');
    fr(5, 14, 5, 1);
    tmp = [];
    for (let i = 6; i < 16; i+=2) {
        tmp.push([2,i],[1,i],[12,i],[13,i]);
    }   
    tmp.push([4,13],[10,13],[10,8],[9,7],[8,7],[8,10],[8,11],[8,12],[7,12]);    
    rmass(tmp);
    fr(7, 3, 1, 5,'#ECEC92');
    rmass([[5,7],[5,8],[5,12],[5,13],[6,9],[6,10],[6,11],[6,13],[7,9]]);    
}

function enemyTankLight(){
   fr(1, 4, 13, 11,'#002C78');
   fr(3, 4, 1, 11,'#C4C4C4');
   fr(8, 4, 1, 5);
   fr(8, 12, 1, 2);   
   fr(11, 4, 1, 11);   
   for(let i = 4+track; i<16; i+=2){
       fr(1, i, 3, 1);//левая гусеница
       fr(11, i, 3, 1);//правая гусеница
   } 
   rmass([[9,8],[9,9],[9,10],[9,11],[5,8],[5,9],[5,10],[5,11],[6,7],[6,8],[6,11],[6,12],[7,7],[7,11],[7,12],[7,13],[8,11]]);
   fr(10, 6, 1, 7,'#F0F0F0');
   fr(7, 0, 1, 7);
   for(let i = 4+track; i<16; i+=2){
       fr(13, i, 1, 1);
   }   
   rmass([[9,5],[9,6],[9,7],[9,12],[9,13],[7,10],[6,10],[6,9],[7,15],[3,4]]);
   cnv.fillStyle = 'black';
   rmass([[4,5],[4,4],[4,13],[4,14],[5,4],[5,14],[10,5],[10,4],[10,13],[10,14],[9,4],[9,14]]);
}

function bullet() {//отрисовка пули
    fr(7, 7, 3, 3, '#DDDDDD');
    fr(8, 6, 1, 1, '#AAAAAA');
    
}
function babax() {
    fr(6, 6, 5, 5,'white');
    fr(7, 7, 3, 3,'red');
}

function eagleBlock(x, y) {
    cnv.fillStyle = 'black'
    cnv.fillRect(0 + x, 0 + y, blockSize * 2, blockSize * 2)
    cnv.fillStyle = 'gray'
    starNew(x, y, 0, 1)
}
function starNew(offsetX, offsetY, spin, gr) {
    let ii = spin, ly = 2 + 3 * gr;
    let r = blockSize;
    let step = ii;
    if (step < 0)
        step += 360;
    let vx = 1, x = 0, y = 0, vy = 1, tri = 0;
    cnv.beginPath();
    for (k = 0; k < ly; k++) {
        switch (Math.floor(step / 90) % 4) {
            case 0:
                vy = -1;
                vx = 1;
                tri = 90;
                break;
            case 1:
                vy = 1;
                vx = 1;
                tri = 0;
                break;
            case 2:
                vy = 1;
                vx = -1;
                tri = 90;
                break;
            case 3:
                vy = -1;
                vx = -1;
                tri = 0;
                break;
            default:
                break;
        }
        x = Math.abs(r * Math.cos(Math.PI * (tri - step % 90) / 180));
        y = Math.abs(r * Math.sin(Math.PI * (tri - step % 90) / 180));
        cnv.lineTo(offsetX + r + vx * x, offsetY + r + vy * y);
        step += 360 / ly * (gr + 1);
    }

    cnv.closePath();
    cnv.fill();
}

function PressKey(e) {
    step = e.keyCode;
    switch (step) {
        case 32: //пробел - выстрел
            if (pulya.x <=0 && pulya.y <= 0) {
                pulya.x = player1.x;
                pulya.y = player1.y;
        }
            break;
        case 37://лево
        case 65://A
            player1.move = 270;
            if (!checkMap(player1,[1,2,4],0)) player1.x -= blockSize/8;
            track = !track;
            break;
        case 38://вверх
        case 87://W
            player1.move = 0;
            if (!checkMap(player1,[1,2,4],0)) player1.y -= blockSize/8; 
            track = !track;
            break;
        case 39://право
        case 68://D
            player1.move = 90;
            if (!checkMap(player1,[1,2,4],0)) player1.x += blockSize/8;
            track = !track;
            break;
        case 40://вниз
        case 83://S
            player1.move = 180;
            if (!checkMap(player1,[1,2,4],0)) player1.y += blockSize/8;
            track = !track;
            break;
        default:
            break;
    }
}
function intdiv(a,b){
    return (a - a % b) / b;
}
function movePule(){
    if (pulya.x <=0 && pulya.y <= 0) {
        pulya.move = player1.move;
        return 0;
    }
    let sel = pulya.move;
    switch (sel) {
        case 0:
            pulya.y-= blockSize/8;
            break;
        case 180:
            pulya.y+= blockSize/8;
            break;
        case 270:
            pulya.x-= blockSize/8;
            break; 
        case 90:
            pulya.x+= blockSize/8;
            break;
        default :
            break;
    }
    if (pulya.x <= 0 || pulya.y <=0 || pulya.x >= obj.width || pulya.y >=obj.height) {
        pulya.x = -blockSize*2;
        pulya.y = -blockSize*2;
    }
    if (checkMap(pulya,[1,2],1)) {
        changePos(babax,pulya.x/blockSize,pulya.y/blockSize,pulya.move);
        pulya.x = -blockSize*2;
        pulya.y = -blockSize*2;
    }
}
function intersects(a, b) {
    return (Math.abs(a.x - b.x) < blockSize && Math.abs(a.y - b.y) < blockSize);
}

function checkMapNew (telo,stopBlock,destroy=0){
    let w , h, checkBlock, chk =0;
    w = intdiv(telo.x,blockSize);
    h = intdiv(telo.y,blockSize);
    
    switch (telo.move) {
        case 0:
            ofsety1 = 0; ofsetx1 = 0;
            ofsety2 = 1; ofsetx2 = 0;
            break;
        case 90:
            ofsety1 = 2; ofsetx1 = 0;
            ofsety2 = 2; ofsetx2 = 1;
            break;
        case 180:
            ofsety1 = 0; ofsetx1 = 2;
            ofsety2 = 1; ofsetx2 = 2;
            break;
        case 270:
            ofsety1 = 0; ofsetx1 = 0;
            ofsety2 = 0; ofsetx2 = 1;
            break;
    }
    checkBlock = map[h+ofsetx1][w+ofsety1];
    if (stopBlock.indexOf(checkBlock) !== -1){
        if (destroy)  map[h+ofsetx1][w+ofsety1]=0;
        chk =1;
    }
    checkBlock = map[h+ofsetx2][w+ofsety2];
    if (stopBlock.indexOf(checkBlock) !== -1){
        if (destroy)  map[h+ofsetx2][w+ofsety2]=0;
        chk =1;
    }
    
    return chk;
}

function checkMap (telo,stopBlock,destroy=0){
    let w , h, checkBlock, chk =0;
    w = intdiv(telo.x,blockSize);
    h = intdiv(telo.y,blockSize);
    switch (telo.move) {
        case 0:
            ofsety1 = 0; ofsetx1 = 0;
            ofsety2 = 1; ofsetx2 = 0;
            break;
        case 90:
            ofsety1 = 2; ofsetx1 = 0;
            ofsety2 = 2; ofsetx2 = 1;
            break;
        case 180:
            ofsety1 = 0; ofsetx1 = 2;
            ofsety2 = 1; ofsetx2 = 2;
            break;
        case 270:
            ofsety1 = 0; ofsetx1 = 0;
            ofsety2 = 0; ofsetx2 = 1;
            break;
    }
    checkBlock = map[h+ofsetx1][w+ofsety1];
    if (stopBlock.indexOf(checkBlock) !== -1){
        if (destroy)  map[h+ofsetx1][w+ofsety1]=0;
        chk =1;
    }
    checkBlock = map[h+ofsetx2][w+ofsety2];
    if (stopBlock.indexOf(checkBlock) !== -1){
        if (destroy)  map[h+ofsetx2][w+ofsety2]=0;
        chk =1;
    }
    
    return chk;
}