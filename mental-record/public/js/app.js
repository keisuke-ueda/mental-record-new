document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('record-form');
    const submitButton = form.querySelector('button[type="submit"]');

    // Ajax保存
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        submitButton.disabled = true;
        submitButton.textContent = 'Saving...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (!response.ok) {
                if (data.errors) {
                    const messages = Object.values(data.errors).flat().join('\n');
                    alert(messages);
                } else {
                    alert('保存に失敗しました');
                }

                submitButton.disabled = false;
                submitButton.textContent = 'Save';
                return;
            }

            window.location.href = data.redirect_url;

        } catch (error) {
            console.error(error);
            alert('通信エラーが発生しました');
            submitButton.disabled = false;
            submitButton.textContent = 'Save';
        }
    });

    // 薬品モーダル
    const modal = document.getElementById('medicine-modal');
    const closeBtn = document.getElementById('medicine-modal-close');
    const modalMedicineName = document.getElementById('modal-medicine-name');
    const modalProductName = document.getElementById('modal-product-name');
    const modalCategory = document.getElementById('modal-category');
    const modalEfficacy = document.getElementById('modal-efficacy');

    if (modal && closeBtn && modalMedicineName && modalProductName && modalCategory && modalEfficacy) {
        document.querySelectorAll('.medicine-name').forEach(function (nameEl) {
            nameEl.addEventListener('click', function () {
                modalMedicineName.textContent = this.dataset.medicine || '情報なし';
                modalProductName.textContent = this.dataset.productName || '情報なし';
                modalCategory.textContent = this.dataset.category || '情報なし';
                modalEfficacy.textContent = this.dataset.efficacy || '情報なし';

                modal.classList.add('show');
            });
        });

        closeBtn.addEventListener('click', function () {
            modal.classList.remove('show');
        });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.remove('show');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                modal.classList.remove('show');
            }
        });
    }
});

// メモ機能
document.addEventListener('DOMContentLoaded', function () {
    const memo = document.getElementById('temporary-memo');
    if (!memo) return;

    const storageKey = 'temporary_memo_shared';

    const savedMemo = localStorage.getItem(storageKey);
    if (savedMemo !== null) {
        memo.value = savedMemo;
    }

    memo.addEventListener('input', function () {
        localStorage.setItem(storageKey, memo.value);
    });
});
