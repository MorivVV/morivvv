{include file="sys/addCSS.tpl" css=['006' => 'homepay']}
{literal}
<div id="homepay">
    <select name="hbil">
        <option v-for="(d, k) in home" :value="k" :selected="k==hId">{{d}}</option>
    </select>    
    <select name="dbil">
        <option v-for="k in jdbil" :value="k" :selected="k==dateb">{{k.toString(10).substr(6,2)+ '-' + k.toString(10).substr(4,2) + '-' + k.toString(10).substr(0,4)}}</option>
    </select>
    <img src="/image/system/add_plus.png" title="Добавить дату" style="height: 25px;"><input type="date" v-model="dateb" name="calendar">
    <div id="billing">
        <div class="bil-line head">
            <div v-for="nam in bilhead" class="onebill">{{nam}}</div>
        </div>

        <div v-for="nam in bill" class="bil-line">
            <div class="onebill" v-html="nam.meter"></div>
            <div class="onebill" v-html="nam.res"></div>
            <div class="onebill" :title="'от ' + nam.DATEBIL.substr(0,10)" v-html="nam.LAST_BIL"></div>
            <div class="onebill" :id="nam.KOD_METER" :title="'от ' + nam.dbil.substr(0,10)" contenteditable="true" @blur="nam.BILLING=+$event.target.innerText" v-html="nam.POST==0 && nam.BILLING !== null ? nam.LAST_BIL : nam.BILLING"></div>
            <div class="onebill" v-html="+nam.POST==0 && nam.BILLING !== null ? nam.BILLING : +nam.BILLING - +nam.LAST_BIL"></div>
            <div class="onebill" :title="'от ' + nam.DATE_RES.substr(0,10)" v-html="nam.cena"></div>
            <div class="onebill" v-html="((+nam.POST==0 && nam.BILLING !== null ? +nam.BILLING : +nam.BILLING - +nam.LAST_BIL)*+nam.cena).toFixed(2)"></div>
        </div>
        <div class="bil-line head">
            <div class="onebill" >Итоги</div>
            <div class="onebill" >{{ bill.reduce(function(sum, nam) {return sum + +(+nam.POST==0 && nam.BILLING !== null ? +nam.BILLING : +nam.BILLING - +nam.LAST_BIL)*+nam.cena}, 0).toFixed(2) }}</div>
        </div>
    </div>
</div>
{/literal}
<script>
let jdata = {$outjson};
let jdbil = {$jdbil};
let dateb = {$dateb};
let home = {$jhome};
let hId = {$ID};
</script>
{include file="sys/addJS.tpl" js=['006' => 'homepay']}
