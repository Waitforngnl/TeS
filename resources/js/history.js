const detailModal = document.getElementById('order-detail-modal');
const itemsListContainer = document.querySelector('#order-detail-modal .overflow-y-auto .space-y-4');

window.openOrderDetail = async function(orderId) {
    if (!detailModal) return;

    detailModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    const titleEl = document.getElementById('modal-order-id');
    if (titleEl) titleEl.textContent = '#' + orderId;

    if (itemsListContainer) {
        itemsListContainer.innerHTML = '<p class="text-center text-gray-500 py-4">Đang tải dữ liệu...</p>';
    }

    try {
        const response = await fetch(`/history/${orderId}`);
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();

        if (data.order && data.order.item && itemsListContainer) {
            renderOrderItems(data.order.item);
        }
    } catch (error) {
        console.error(error);
        if (itemsListContainer) {
            itemsListContainer.innerHTML = '<p class="text-center text-red-500 py-4">Không thể tải thông tin đơn hàng.</p>';
        }
    }
};

window.closeOrderDetail = function() {
    if (detailModal) {
        detailModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
};

function renderOrderItems(items) {
    let html = '';
    const formatter = new Intl.NumberFormat('vi-VN');

    items.forEach(item => {
        const productName = item.product_name || item.name || 'Sản phẩm';
        // Prefer unit_price stored in DB, fallback to price for compatibility
        const price = (item.unit_price ?? item.price ?? item.unitPrice) || 0;
        const qty = item.quantity || 0;
        const total = (item.line_total ?? (price * qty)) || 0;

        // Determine image URL: prefer product.image_url, then item.image, else fallback
        let imageUrl = '/images/no-img.jpg';
        if (item.product && item.product.image_url) {
            const img = item.product.image_url;
            imageUrl = (/^https?:\/\//i.test(img)) ? img : (img.startsWith('/') ? img : '/' + img);
        } else if (item.image) {
            const img = item.image;
            imageUrl = (/^https?:\/\//i.test(img)) ? img : (img.startsWith('/') ? img : '/' + img);
        }

        html += `
            <div class="flex items-center gap-4 py-2 border-b border-gray-100 last:border-0">
                <div class="h-16 w-16 bg-gray-100 rounded border border-gray-200 overflow-hidden flex-shrink-0">
                     <img src="${imageUrl}" alt="${productName}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-800">${productName}</h4>
                    <p class="text-xs text-gray-500">Đơn giá: ${formatter.format(price)}đ</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">${formatter.format(total)}đ</p>
                    <p class="text-xs text-gray-500">x${qty}</p>
                </div>
            </div>
        `;
    });
    itemsListContainer.innerHTML = html;
}

document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        window.closeOrderDetail();
    }
});