const mainSidebar = '<div><div id="main_sidebar"><ul><li>Меню</li>'+
            '<li v-for="url in url_list" v-if="url.kod_url==0"><a name="url" :href="\'/\'+url.url" >{{url.url_name}}</a>'+
            '<ul><li v-for="surl in url_list" v-if="url.id == surl.kod_url"><a name="url" :href="\'/\'+surl.url" >{{surl.url_name}}</a></li></ul></li></ul></div>'+
    '<div id="top_nav"><div class="top_table"><div class="menu">Меню</div><ul class="topmenu">'+
                '<li v-for="url in url_list" v-if="url.kod_url==0"><a name="url" class="c" :href="\'/\'+url.url" >{{url.url_name}}</a>'+
                '<ul class="submenu"><li v-for="surl in url_list" v-if="url.id == surl.kod_url"><a name="url" class="c" :href="\'/\'+surl.url" >{{surl.url_name}}</a></li>'+
                '</ul></li></ul></div></div></div>';