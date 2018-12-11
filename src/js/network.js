/*
    Properties are as follows:
    {
        url: <request destination path>
        method: <request method (capital letters)>
        content: <javascript object representing the data to be sent>
    }
*/

function request(properties){

    const csrfToken = getCookie('CSRF-TOKEN');
    
    let url = properties.url;
    let method = properties.method || 'GET';
    let options = {
        method: method,
        headers: {'X-XSRF-TOKEN': csrfToken}
    };

    if(method === 'GET'){
        url += getGetParams(properties.content);
    }else if(method === 'PUT' || method === 'DELETE'){
        options.body = JSON.stringify(properties.content);
    }else{
        options.body = getPOSTbody(properties.content);
    }

    fetch(url, options)
}


function getGetParams(params){
    if(Object.keys(params).length <= 0)
        return '';

    let url = '?'
    Object.keys(params).forEach(key => {
        url += `${key}=${params[key]}&`;
    });
    url = url.slice(0, -1);
    return url;
}

function getPOSTbody(params){
    let formdata = new FormData();
    Object.keys(params).forEach(key => {
        formdata.append(key, params[key]);
    });
    return formdata;
}