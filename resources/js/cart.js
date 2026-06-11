let formToSubmit = null;

window.checkQuantity = function(btn, quantity) {
    if (quantity > 1) {
        btn.closest('form').submit();
    } else {
        formToSubmit = btn.closest('form');
        const modal = document.getElementById('confirm-delete-modal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }
};

window.closeModal = function() {
    const modal = document.getElementById('confirm-delete-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
    formToSubmit = null;
};

window.openCheckoutModal = function() {
    const modal = document.getElementById('checkout-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } else {
        console.error('Không tìm thấy modal có id="checkout-modal"');
    }
}

window.closeCheckoutModal = function() {
    const modal = document.getElementById('checkout-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const confirmBtn = document.getElementById('confirm-btn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if(formToSubmit) {
                formToSubmit.submit();
            }
        });
    }

    // (Tùy chọn) Đóng modal khi bấm ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            window.closeModal();
            window.closeCheckoutModal();
        }
    });
});