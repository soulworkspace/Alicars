(() => {
    const previewCache = new Map();
    let requestTimer;

    const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
    }[character]));

    const renderPreview = (card, data) => {
        const gallery = (data.images || []).map((image) => {
            const imageElement = document.createElement('img');
            imageElement.src = image;
            imageElement.alt = '';
            return imageElement.outerHTML;
        }).join('');
        const spec = (label, value) => `<div><dt>${label}</dt><dd>${escapeHtml(value || 'N/A')}</dd></div>`;
        card.querySelector('.car-preview__loading').hidden = true;
        card.querySelector('.car-preview__content').innerHTML = `
            <div class="car-preview__gallery">${gallery || '<div></div>'}</div>
            <div class="car-preview__eyebrow">${escapeHtml(data.category || 'Vehicle')} · ${escapeHtml(data.condition || 'Used')}</div>
            <h6 class="car-preview__title">${escapeHtml(data.title || 'Vehicle')}</h6>
            <dl class="car-preview__specs">
                ${spec('Engine', data.specs?.engine)}
                ${spec('Fuel', data.specs?.fuel)}
                ${spec('Mileage', data.specs?.mileage)}
                ${spec('Documents', data.specs?.documents)}
            </dl>
            <div class="car-preview__price">${escapeHtml(data.price || 'Contact for price')}</div>
            ${data.description ? `<p class="car-preview__description">${escapeHtml(data.description)}</p>` : ''}`;
    };

    const loadPreview = (card) => {
        const url = card.dataset.previewUrl;
        if (!url || previewCache.has(url)) {
            if (previewCache.has(url)) renderPreview(card, previewCache.get(url));
            return;
        }

        clearTimeout(requestTimer);
        requestTimer = setTimeout(() => {
            fetch(url, { headers: { Accept: 'application/json' } })
                .then((response) => response.ok ? response.json() : Promise.reject(response))
                .then((data) => { previewCache.set(url, data); renderPreview(card, data); })
                .catch(() => { card.querySelector('.car-preview__loading').textContent = 'Preview unavailable'; });
        }, 120);
    };

    document.querySelectorAll('[data-preview-url]').forEach((card) => {
        card.addEventListener('mouseenter', () => { card.classList.add('preview-open'); loadPreview(card); });
        card.addEventListener('mouseleave', () => card.classList.remove('preview-open'));
        card.addEventListener('focusin', () => { card.classList.add('preview-open'); loadPreview(card); });
        card.addEventListener('focusout', (event) => {
            if (!card.contains(event.relatedTarget)) card.classList.remove('preview-open');
        });
    });
})();
