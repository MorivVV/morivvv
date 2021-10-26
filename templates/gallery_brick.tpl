{include file="sys/addCSS.tpl" css=array('masonry')}

{include file='gallery/loadImage.tpl'}

<input type="button" onclick="picrecalc({$hdef})" value="исправить" >
<div id="gallery" >
    <div class="gal_nav gal_next">{literal} 
       <a v-for="fd in folders" v-if="fd.ID != folder" @click.prevent="nextFolder(fd.ID, $event)" :href="'/gallery/'+gallery+'-'+fd.ID+'-0-'+step">{{fd.NAIMEN_FOLDER}}</a><b v-else=""> {{fd.NAIMEN_FOLDER}} </b>
    <img onclick="addFolder(this)" style="height:25px" src="/image/system/add_plus.png" title="Добавить папку">
    {/literal} </div>
    <galpage :lim="+lim" :cnt="+cnt" :step="+step" :folder="+folder" :gallery="gallery" @selectpage="lim = $event"></galpage>
    <div id="wrapper" class="wrapper">
        <div v-for="f in files" class="imgblock" onclick='viewPicture(this)'><img class="imgbrick" :src="'{$dirfoto}'+f.t" ></div>
    </div>
    <galpage :lim="+lim" :cnt="+cnt" :step="+step" :folder="+folder" :gallery="gallery" @selectpage="lim = $event"></galpage>
</div>
<div id="previewimage" onclick="hidePicture()" ><img src=""></div>
<script >
let lim = {$lim},
    gallery= '{$tpl}',
    folder= {$folder},
    step= {$step},
    cnt= {$cnt},
    folders= {$jfolders};
 </script>
{include file="sys/addJS.tpl" js=array('gallery_view','gallery_masonry','vue/galleryTemplate')}
<script >
    let clh =$('.wrapper')["0"].clientWidth;
window.onresize =  function() { 
    if (clh !==$('.wrapper')["0"].clientWidth){
    clh =$('.wrapper')["0"].clientWidth;
    picrecalc({$hdef});}
}
</script>