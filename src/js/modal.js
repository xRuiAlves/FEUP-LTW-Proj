let ModalHandler = {};

window.addEventListener('load', function() {
    ModalHandler.DOM = document.createElement('DIV');
    ModalHandler.DOM.addEventListener('click', e => { if(e.target === ModalHandler.DOM) ModalHandler.hide()});
    ModalHandler.DOM.id = 'modal-container';
    document.body.appendChild(ModalHandler.DOM);

    ModalHandler.show = (Elem) => {
        while (ModalHandler.DOM.firstChild) {
            ModalHandler.DOM.removeChild(ModalHandler.DOM.firstChild);
        }
        ModalHandler.DOM.appendChild(Elem);
        document.body.classList.add('modal-open');
    };

    ModalHandler.hide = () => {
        ModalHandler.DOM.classList.remove('modal-container');
        document.body.classList.remove('modal-open');
    };
});
