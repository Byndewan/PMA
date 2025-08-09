<div id="modal-container"
     class="fixed inset-0 z-[100] hidden items-center justify-center"
     aria-hidden="true"
     role="dialog"
     aria-modal="true">
    <div class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
         onclick="closeModal()"
         aria-label="Close modal"></div>

    <div class="modal-content relative z-50 bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all"
         role="document">
        <button class="close-modal absolute top-4 right-4 p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 transition-colors"
                onclick="closeModal()"
                aria-label="Close modal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div id="modal-body" class="p-6"></div>
    </div>
</div>

<script>
function closeModal() {
    const modal = document.getElementById('modal-container');
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('overflow-hidden');

    // Set focus back to the element that opened the modal
    if (window.lastFocusedElement) {
        window.lastFocusedElement.focus();
    }
}

function openModal(url, title = '') {
    // Store the currently focused element
    window.lastFocusedElement = document.activeElement;

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.text();
    })
    .then(html => {
        const modal = document.getElementById('modal-container');
        document.getElementById('modal-body').innerHTML = html;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        // Set focus to the modal
        modal.focus();

        // Update modal title if provided
        if (title) {
            modal.setAttribute('aria-label', title);
        }

        // Trap focus inside modal
        trapFocus(modal);
    })
    .catch(error => {
        console.error('Error loading modal content:', error);
        alert('Gagal memuat konten. Silakan coba lagi.');
    });
}

function trapFocus(modal) {
    const focusableElements = modal.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    });

    firstElement.focus();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('modal-container').classList.contains('hidden')) {
        closeModal();
    }
});
</script>
