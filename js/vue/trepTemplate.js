const topicPage = '<div id="topicPage" class="topic-page">'+
        'Всего {{ full }}. Отображаются с {{ current+1 }} по <span v-if="current+onPage>full">{{ full }}</span> <span v-else >{{ current+onPage }}</span>'+
        '<span v-for="i in (full-full%onPage)/onPage+1" class="page">'+
        '<span v-if="(i-1)*onPage == current"> {{ i }} </span>'+
        '        <a v-else :href="\'/topic/\'+topic+\'-\'+(i-1)*onPage+\'---\'+tpl" @click.prevent="nextPage((i-1)*onPage,$event)">{{ i }}</a></span></div>';
const messageList = '<div id="messageList" class="messageBlock">'+
    '<topic-page :current="current" @changepage="current=$event" />'+
    '  <div class="trep_message" v-for="tr in jsontrepdata">'+
    '<div class="message_head">'+
    '    <div class="message_time">{{ tr.TIME_ADD }}</div>'+
    '    <div class="message_number"><a :href="\'/post/\'+tr.id_theme+\'--\'+tr.UID+\'-\'+tr.ID+\'-\'+tpl">{{ tr.ID }}</a>'+
    '    <img v-if="tr.UID == user_id" onclick="changePost(this)" src="/image/system/pen.png" height="16px" title="редактировать сообщение" :alt="tr.ID" >'+
    '    <img v-if="tr.UID == user_id" onclick="deletePost(this)" src="/image/system/delete.gif" height="16px" title="удалить сообщение" :alt="tr.ID" >'+
    '    </div>'+
    '</div>'+
    '<div class="user info" >'+
    '    <div class="user name"><a style="text-decoration: none" :href="\'/profile/\'+tr.USER_NAME"><font :color="tr.color" face="Arial">{{ tr.USER_NAME }}</font></a></div>'+
    '   <div class="user rank">Сообщений:</div>'+
    '    <div class="user rank"><a :href="\'/usermessage/--\'+tr.UID">{{ tr.allPost }} всего</a></div>'+
    '    <div class="user rank"><a :href="\'/usermessage/\'+tr.TID+\'--\'+tr.UID">{{ tr.currentPost }} в ветке</a></div>'+
    '    <div class="user avatar"><a :href="\'/profile/\'+tr.USER_NAME"><img class="topic_caver" :src="\'/img.php?tumbs=\'+tr.image"></a></div>'+
    '    <div class="user rank"><font :color="tr.color" face="Arial">{{ tr.RANK }}</font></div>'+
    '    <div class="user rank"><input type="button" onclick="quotedPost(this)" :id="tr.ID" value="Ответить"/></div>'+
    '</div>'+
    '<div class="trep_text" v-html="bbCode(tr.POST, tr.ID)">'+
    '    <div v-if="tr.KOD_QUOTED_POST>0" onclick="viewPost(this)" :id="tr.KOD_QUOTED_POST" class="message-quoted"><a >{{ tr.KOD_QUOTED_POST }} от {{ tr.quser }}</a>  </div>'+
    '        <div v-if="tr.quoted>0" class="answer">{{ tr.quoted }}</div></div></div>'+
    '<topic-page :current="current" @changepage="current=$event" /></div>';
const forumList = '<div v-if="treptheme.length > 0" id="forumList" class="forum_list" >'+
    '<div class="theme_head">'+
    '    <div class="topic_theme">'+
    '        <div class="theme">Тема</div>'+
    '    </div>'+
    '    <div class="theme_info">'+
    '        <div class="count_post">сообщений {{ user_id>0 ? \'/прочитано\' : \'\' }}</div>'+
    '        <div class="last_autor">последнее</div>'+
    '    </div>'+
    '    <div class="created">'+
    '        <div class="time">Создано</div>'+
    '        <div class="autor_theme">автор</div>'+
    '   </div></div>'+
    '<div class="topic_view" v-for="tr in treptheme" >'+
    '    <div class="topic" >'+
    '        <div class="topic_theme">'+
    '            <div class="theme" :class="{ private : tr.private === 1 }">'+
    '                 <a :class="{ novisit : tr.readTopic === 0, readall : tr.readTopic === tr.cnt, visit : tr.readTopic > 0 && tr.readTopic < tr.cnt }"'+
    '                    :href="\'/topic/\'+tr.id">{{ tr.theme }}</a>'+
    '                <span v-if="tr.child>0">вложеные форумы: {{ tr.child }}</span></div></div>'+
    '<div class="theme_info">'+
    '            <div class="count_post">{{ tr.cnt }}{{ user_id>0 ? \'/\'+ tr.readTopic : \'\' }}'+
    '                <a title="легкая текстовая версия" :href="\'/topic/\'+tr.id+\'----print\'">'+
    '                    <img style="margin-left:5px; height:20px;" src="/image/system/txt.png"></a></div>'+
    '           <div class="last_autor"><a :href="\'/post\'+tr.id+\'---\'+tr.pun" :title="tr.pst">{{tr.pun}}</a></div></div>'+
    '       <div class="created">'+
    '            <div class="time">{{tr.tcreate}}</div>'+
    '            <div class="autor_theme"><a :href="\'/profile/\'+tr.USER_NAME">{{tr.USER_NAME}}</a></div></div></div></div></div>';
let comp = {
    template: topicPage,
    props:{
        current: Number
    },
    methods:{
        nextPage: function(page, e) {
            this.current = +page;
            history.pushState(null, null, e.target.href);
            this.$emit("changepage",this.current)
        }
    },
    data: {
            user_id: user_id,
            topic: topic,
            tpl: '',
            full: full,
            onPage: onPage  
    }
};
let f = new Vue({
    el: '#forumList',
    data: {
            treptheme:treptheme,
            user_id:user_id,
            topic:topic,
            tpl: 'new'
    },
    template: forumList
});
let m = new Vue({
    el: '#messageList',
    data: {
            jsontrepdata: [],
            user_id:user_id,
            user:user,
            topic:topic,
            post: 0,
            current:current,
            onPage:onPage,
            tpl: ''
    },
    components: {
       'topic-page':comp
    },
    template: messageList,
    mounted: function (){
        this.getForum();     
    },
    watch:{
        current: function() {
            this.getForum();
        } 
    },
    methods:{
        bbCode: function(text, id) {
            return ruleBB(text, id);},
        getForum: function(){
            var oReq = new XMLHttpRequest();  
            oReq.onload = function(){
                m.jsontrepdata = JSON.parse(this.responseText); 
            };  
            oReq.onerror = function(err) {  
                console.log('Fetch Error :-S', err);  
              }  
            oReq.open('get', '/getForum/'+this.topic+'-'+this.current+'-'+this.onPage+'-'+this.user+'-'+this.post+'$', true);  
            oReq.send();
        }
        }
})