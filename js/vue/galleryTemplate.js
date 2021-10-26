const galleryPageTemplate = 
'<div id="galleryPage" class="gal_nav gal_next">'+
    '<a v-for="page in ~~(cnt/step)+1"'+ 
       ' v-if="lim !== (page-1)*step" @click.prevent="nextPage((page-1)*step, $event)" '+
       ' :href="\'/gallery/\'+gallery+\'-\'+folder+\'-\'+(page-1)*step+\'-\'+step"> {{(page-1)*step}} </a>' +
'<b v-else="">{{lim}}</b></div>';

let galPage = {
    template: galleryPageTemplate,
    props: {
        folder: Number,
        gallery: String,
        step: Number,
        cnt: Number,
        lim: Number
    },
    methods: {
        nextPage: function(page, e){
            this.lim = +page;
            history.pushState(null, null, e.target.href);
            this.$emit('selectpage',this.lim);
        }
    }
};
    
let gal = new Vue({
    el: '#gallery',
    data: {
            files: [],
            lim:lim,
            gallery:gallery,
            folder:folder,
            step:step,
            cnt:cnt,
            folders:folders
    },
    methods:{
        nextFolder: function(folder, e){
            this.folder = +folder;
            history.pushState(null, null, e.target.href);
            var f = this.folder;
            this.cnt = this.folders.find(function (n) {
                return n['ID'] == f;}).cnt;
            this.lim = 0;
        },
        getGallery:function(){
            var oReq = new XMLHttpRequest();  
            oReq.onload = function(){
                gal.files = JSON.parse(this.responseText); 
            };  
            oReq.onerror = function(err) {  
                console.log('Fetch Error :-S', err);  
              }  
            oReq.open('get', '/getGallery/'+this.gallery+'-'+this.folder+'-'+this.lim+'-'+this.step+'$', true);  
            oReq.send();
            setTimeout(picrecalc,500,180);
        }
    },
    mounted: function (){
        this.getGallery();     
    },
    components: {
       'galpage': galPage
    },
    watch:{
        lim: function(newValue) {
            this.getGallery();
          },
        folder: function(newValue) {
            this.getGallery();
          }
    }
});
