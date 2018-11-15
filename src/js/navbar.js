
window.addEventListener('load', function() {
    var login_slider = document.getElementById('login_slider');
    var hamburguer = document.getElementById('side-menu-hamburguer');
    login_slider.addEventListener("click", () =>
        login_slider.classList.toggle('active')
    );
    hamburguer.addEventListener("click", () => 
        document.querySelector("#topbar .page-side-menu").classList.toggle('active')
    )
})
