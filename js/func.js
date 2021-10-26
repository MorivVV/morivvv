const serv = '';

function AjaxRequest(url, postdata, setPerem, arrParam) {
    if (typeof arrParam === 'undefined') {
        arrParam = []
    }
    let oxhl = new XMLHttpRequest();
    let data = new FormData();
    postdata.forEach(function(e) {
        let key = Object.keys(e)['0']
        if (Array.isArray(e[key])) {
            e[key].forEach(function(ee) {
                data.append(key + '[]', ee);
            })
        } else {
            data.append(key, e[key]);
        }

    });
    oxhl.onload = function() {
        this.arrParam = arrParam
        setPerem(this)
    };
    oxhl.onerror = function(err) {
        console.log('Fetch Error :-S', err);
    }
    oxhl.open('post', serv + url, true);
    oxhl.send(data);

}

function getCookie(param) {
    let cookies = document.cookie.split(";")
        .map(function(e) { return e.split('=').map(function(e) { return e.trim() }) })
        .filter(function(e) { return e[0] === param })
    if (cookies.length > 0) {
        return cookies['0']['1']
    } else {
        return ''
    }

}