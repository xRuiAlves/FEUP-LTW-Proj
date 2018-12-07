g_appState = {
    onload: []
}

g_appState.addEventListener = (identifier, callback) =>
    identifier === 'load' && g_appState.onload.push(callback)

fetch('api/user/info')
.then(res => res.json())
.then(data => {
    g_appState = {...g_appState, ...data};
    for(let callback of g_appState.onload){
        callback(g_appState);
    }
})