<form enctype="multipart/form-data" action="/uploadImage" method="POST">
    Для загрузки новых фотографий <input type="file" name ="imgupload" multiple='true' min='1' max='10' onchange="multiLoad(this)">

</form>
<div id="dropZone">
        Или, перетащите файлы сюда.
</div>