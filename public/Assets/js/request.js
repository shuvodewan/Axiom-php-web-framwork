

function get($url,callback=null){
    fetch($url)
    .then(response => {
        return response.json(); // Parse response JSON
    })
    .then(result => {
        callback(result.data,result.status)
        return {data:result.data,status:result.status}
    })
}

function post($url,data,headers,callback){
    fetch($url, {
        method: 'POST',
        body: data,
        headers:headers
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        callback(data)
    })
}
