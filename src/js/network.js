/*
    Properties are as follows:
    {
        url: <request destination path>
        method: <request method (capital letters)>
        content: <javascript object representing the data to be sent>
    }
*/

function request(properties){

    return new Promise(async function(resolve, reject) {
        const csrfToken = localStorage.getItem('CSRF-TOKEN');

        let url = properties.url;
        let method = properties.method || 'GET';
        let content = properties.content || {};
        let options = {
            method: method
        };

        content = {...content, csrf_token: csrfToken};

        if(method === 'GET'){
            url += getGetParams(content);
        }else if(method === 'PUT' || method === 'DELETE'){
            options.body = JSON.stringify(content);
        }else{
            options.body = getPOSTbody(content);
        }

        let response = await fetch(url, options)
        .then(res => {
            return {status: res.status, result: res.json()};
        })
        .catch(reject)

        response.result.then(data => {
            if(response.status == 200 || response.status == 201){
                resolve(data);
            }else{
                reject(data);
            }
        }).catch(() => resolve({})); //json is empty
    })
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