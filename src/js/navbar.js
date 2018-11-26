
window.addEventListener('load', function() {
    let login_slider = document.getElementById('login_slider');
    let hamburguer = document.getElementById('side-menu-hamburguer');
    let side_menu = document.querySelector('#topbar .page-side-menu');
    let page_content = document.getElementById('page-content');
    login_slider.addEventListener("click", () => {
        if(login_slider.classList.contains('active')){
                side_menu.classList.remove('active');
                login_slider.classList.remove('active');
        }else{
            showLoginForm().then(() => {
                login_slider.classList.add('active');
            });
        }
        
    });
    hamburguer.addEventListener("click", () => 
        side_menu.classList.toggle('active')
    );
    page_content.addEventListener("click", () => 
        side_menu.classList.remove('active')
    );
})
