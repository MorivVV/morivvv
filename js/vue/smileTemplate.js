const smileTemplate = '<div id="ldsml"><a v-if="smiles_page > 0" :id="smile_name" :name="smiles_page - outsmile" @click="getSmileJson(-outsmile)"><img src="/image/system/previous.png"></a>'+
        '<img v-for="sm in smlist" onclick="smileInsert(this)" class="smileadd" :src="\'/image/\'+smile_name+\'/\'+sm" :alt="(smile_name == \'tumbs\') ? (\'[IMG]\' + sm + \'[/IMG]\') : (\'*\' + smile_name + sm.replace(\'.\',\'\') + \'*\')">'+
    '<a v-if="smlist.length >= 49" :id="smile_name" @click="getSmileJson(smlist.length)"> <img src="/image/system/next.png"></a></div>';

let smcomp = {
    template: smileTemplate,
    props: {
        smile_name: String, 
        smiles_page: {
            type: Number,
            required: true,
            default:0
          }},
    data: {
        smlist: [],
        outsmile: 50
  },
  watch:{
      smile_name: function(newValue) {
        this.getSmileJson(0);
    }
  },
  methods: {
        getSmileJson: function(iter) {
            this.smiles_page = +this.smiles_page + iter;
            let formData = new FormData();
            formData.append('page', this.smiles_page);
            formData.append('name', this.smile_name);
            var oReq = new XMLHttpRequest();  
            oReq.onload = function(){
                smcomp.smlist = JSON.parse(this.responseText); 
            };  
            oReq.onerror = function(err) {  
                console.log('Fetch Error :-S', err);  
              }  
            oReq.open('POST', '/getsmile$', true);  
            oReq.send(formData);
            
//            fetch('/getsmile$',{
//                method: 'POST',
//                body: formData
//              })
//            .then(response => response.json())
//            .then(json => {this.smlist = json});     
        }
    }
};
let smiles = new Vue({
    el: '#newMessage',
    data(){
            smilename: ''
    },
    methods: {
        setSmile: function(event) {
            this.smilename = event.target.id
        }
    },
    components: {
       'ldsml': smcomp
    },
});