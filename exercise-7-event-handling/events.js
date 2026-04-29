document.addEventListener('DOMContentLoaded', function() {
    const toggleSkills = document.getElementById('toggleSkills');
    const certCountButton = document.getElementById('certCountButton');
    const eventFeedback = document.getElementById('eventFeedback');
    const skillTip = document.getElementById('skillTip');
    const certificateLinks = document.querySelectorAll('a[target="_blank"]');
    const navLinks = document.querySelectorAll('a[href$=".html"]');

    if (toggleSkills) {
        toggleSkills.addEventListener('click', function() {
            if (skillTip.style.display === 'none' || !skillTip.style.display) {
                skillTip.style.display = 'block';
                toggleSkills.textContent = 'Hide skill tip';
                eventFeedback.textContent = 'Skill tip shown — click again to hide it.';
            } else {
                skillTip.style.display = 'none';
                toggleSkills.textContent = 'Show skill tip';
                eventFeedback.textContent = 'Skill tip hidden.';
            }
        });
    }

    if (certCountButton) {
        certCountButton.addEventListener('click', function() {
            eventFeedback.textContent = `You have ${certificateLinks.length} certificates listed.`;
        });
    }

    certificateLinks.forEach(function(link) {
        link.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#dbeee4';
        });
        link.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });

    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            eventFeedback.textContent = `Navigating to ${this.textContent.trim()}...`;
        });
    });

    // Product selection events
    const productForm = document.getElementById('productForm');
    if (productForm) {
        productForm.addEventListener('change', updateProductSummary);
        productForm.addEventListener('input', updateProductSummary);
        updateProductSummary();
    }
});

function updateProductSummary() {
    const summary = document.getElementById('productSummary');
    if (!summary) {
        return;
    }

    const rows = document.querySelectorAll('#productForm tr');
    let selectedCount = 0;
    let subtotal = 0;

    rows.forEach(row => {
        const checkbox = row.querySelector('input[type="checkbox"][data-price]');
        const qtyInput = row.querySelector('input[type="number"]');
        if (!checkbox || !qtyInput) {
            return;
        }

        if (checkbox.checked) {
            selectedCount += 1;
            const units = parseInt(qtyInput.value, 10) || 1;
            subtotal += units * parseInt(checkbox.dataset.price, 10);
        }
    });

    if (selectedCount === 0) {
        summary.textContent = 'No products selected yet.';
    } else {
        summary.textContent = `Selected ${selectedCount} item(s). Estimated subtotal: Rs ${subtotal.toLocaleString()}.`;
    }
}
