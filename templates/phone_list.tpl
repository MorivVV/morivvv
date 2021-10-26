<link rel='stylesheet' type='text/css' media="screen" href='/css/phones.css' />
<script>
	function addCompList(e) {
	var sel = "#kod_" + e.id;
	var save = e.innerText;
	var cl = $(sel).clone();
	var cnt = cl["0"].children.length - 1;
	if (cl["0"].localName == "select"){
		for (var i = 0; cnt; i++)
			if (cl["0"].children[i].innerText == save){
				cl["0"].children[i].selected = true;
				break;
				}
		}	
		else
			cl["0"].childNodes["0"].value = save;
	$(e).empty();
	$(e).append(cl);
	
	} 
</script>
<div id="listphone">
<form action="/phones" method="post">
	<select name="SORT">
		<option selected value="ASC">По возрастанию</option>
		<option value="DESC">По убыванию</option>
	</select>
	<select name="BY">
            <option v-for="(val, key) in column" :value="key" :selected="key == 'ID'" v-html='val'></option>
	</select>
	<select name="STR">
	{for $i=0 to $cnt}
		<option value="{$i}">{$i*25} - {($i+1)*25}</option>
	{/for}	
		</select>
		<input type="submit">
	</form>

<div class="phone">
    <div v-for="(val, key) in column" :class='"iphon "+key' v-html='"<b>"+val+"</b>"'></div>
</div>			

<div v-for="p in phones" class="phone">
        <div v-for="(val, key) in p" 
             v-if="key.substr(0,3) != 'ref'" 
             :class='"iphon "+key' 
             ondblclick="addCompList(this)" 
             :id="key" 
            v-html="phoExtract(p, key, val)">  
        </div>
</div>

<form action="/addPhone" method="post">
<div class="phone">
	<div class="iphon id"><b>#</b></div>
	<div class="iphon name"><input id="kod_name" type="text" value="" name="phone_name"></div>
        <div class="iphon company"><select id="kod_company" name="kod_company"><option v-for="c in company" :value="c.id" v-html="c.n"></option></select></div>
	<div class="iphon processor"><select id="kod_processor" name="kod_processor"><option v-for="c in cpu" :value="c.id" v-html="c.n"></option></select></div>
	<div class="iphon display"><select id="kod_display" name="display_pixel"><option v-for="c in display" :value="c.id" v-html="c.n"></option></select></div>
	<div class="iphon display-width" id="kod_display-width"><input value="" name="display"></div>
	<div class="iphon ram"><select id="kod_ram" name="ram"><option v-for="c in ram" :value="c.id" v-html="c.n"></select></div>
	<div class="iphon flash"><select id="kod_flash" name="flash"><option v-for="c in ram" :value="c.id" v-html="c.n"></select></div>
	<div class="iphon rearcamera"><select  id="kod_rearcamera" name="camera_front"><option v-for="c in pixel" :value="c.id" v-html="c.n"></option></select></div>
	<div class="iphon frontcamera"><select  id="kod_frontcamera" name="camera_rear"><option v-for="c in pixel" :value="c.id" v-html="c.n"></option></select></div>
	<div class="iphon scanner" id="kod_scanner"><input  type="checkbox" onclick="ScanerChange(this)" value="" name="scanner"></div>
	<div class="iphon battery" id="kod_battery"><input type="text" value="" name="battery"></div>
	<div class="iphon antutu" id="kod_antutu"><input type="text" value="" name="ANTUTU"></div>
	<div class="iphon weight" id="kod_weight"><input type="text" value="" name="weight"></div>
	
</div>		<input class="add_phone" value="Добавить" type="submit">
</form> 
</div>
<script>
    let phl = new Vue({
        el: '#listphone',
        data: {
            company: {$company},
            pixel: {$pixel},
            phones: {$phones},
            cpu: {$cpu},
            display: {$display},
            ram: {$ram},
            column:{$val},
        },
        methods:{
            phoExtract: function(row, key, val) {
                let res;
                switch (key) {
                    case 'scanner':
                        res = '<input type=checkbox '+ (val == 1 ? 'checked' : '') +' onclick=ScanerChange(this) value='+val+' name=scanner>'; 
                        break;
                    case 'name':
                        res = '<a href="/phone/'+row.id+'">'+val+'</a>'; 
                        break;
                    default:
                        res = val;
                        break;
                }
                return res;
            }
            }
    });
</script>
    