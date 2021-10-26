<link rel='stylesheet' type='text/css' media="screen" href='css/userlist.css' />
<div id="userlist">
    <form action="/users" method="post">
        <select name="SORT">
            <option selected value="ASC">По возрастанию</option>
            <option value="DESC">По убыванию</option>
        </select>
        <select name="BY">
            <option selected value="ID">ID</option>
            <option value="USER_NAME">Никнейм</option>
            <option value="NAME">Имя</option>
            <option value="FAMILY">Фамилия</option>
        </select>
        <select name="STR">
            {for $i=0 to $cnt}
                <option value="{$i}">{$i*25} - {($i+1)*25}</option>';
            {/for}
        </select>
        <input type="submit">
    </form>
    <h1>Пользователи сайта</h1>
    <div class="userlist_head">
        <div class="user_id">ID</div>
        <div class="user_name">Никнейм</div>
        <div class="family" id="family" >Фамилия</div>
        <div class="name" id="name" >Имя</div>	
        <div class="surname" id="surname" >Отчество</div>
        <div class="rank" id="rank" >Ранг</div>
    </div>
    {literal}
    <div v-for="user in users" class="userdata">
        <div class="user_id">{{user.id}}</div>
        <div class="user_name"><a :href="'/profile/'+user.id">{{user.user_name}}</a></div>
        <div class="family" id="family" >{{user.family}}</div>
        <div class="name" id="name" >{{user.name}}</div>
        <div class="surname" id="surname" >{{user.surname}}</div>
        <div class="rank" id="rank" >{{user.rank}}</div>
    </div>
</div>        
    {/literal}
<script>
    let users = {$data}
let vUserList = new Vue({
    el: '#userlist',
    data: {
        users: users
    }
})
</script>