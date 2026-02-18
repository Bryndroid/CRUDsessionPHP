const cartModal = document.getElementById('cart-modal');


function openCart() {

    cartModal.classList.remove('hidden');

    document.body.style.overflow = 'hidden';
  
}


function closeCart() {
 
    cartModal.classList.add('hidden');

    document.body.style.overflow = 'auto';
}


window.onclick = function(event) {
    if (event.target == cartModal) {
        closeCart();
    }
}


document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !cartModal.classList.contains('hidden')) {
        closeCart();
    }
});


//Acá voy a consumir por fetch cada enpoint 

