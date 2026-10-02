(() => {
    const form = document.getElementById('pgdeCampaignForm');
    if (!form) return;

    const count = document.getElementById('pgdeAudienceCount');
    const state = document.getElementById('pgdeAudienceState');
    const subject = form.querySelector('[data-campaign-subject]');
    const body = form.querySelector('[data-campaign-body]');
    const previewSubject = document.querySelector('[data-preview-subject]');
    const previewBody = document.querySelector('[data-preview-body]');
    let timer;

    const updatePreview = () => {
        if (previewSubject) previewSubject.textContent = subject?.value.trim() || 'Objet de votre e-mail';
        if (previewBody) previewBody.textContent = body?.value.trim() || 'Votre message apparaîtra ici au fur et à mesure de votre rédaction.';
    };

    subject?.addEventListener('input', updatePreview);
    body?.addEventListener('input', updatePreview);

    const loadAudience = async () => {
        const params = new URLSearchParams();
        form.querySelectorAll('[data-audience-filter]').forEach((field) => {
            if (field.value !== '') params.set(field.name, field.value);
        });

        state?.classList.remove('is-error');
        state?.classList.add('is-loading');
        if (state) state.innerHTML = '<i class="fas fa-circle" aria-hidden="true"></i> Mise à jour…';

        try {
            const response = await fetch(`${form.dataset.audienceUrl}?${params.toString()}`, {
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin',
            });
            if (!response.ok) throw new Error('Audience unavailable');
            const data = await response.json();
            if (count) {
                count.textContent = new Intl.NumberFormat('fr-FR').format(data.count);
                count.classList.remove('is-changing');
                requestAnimationFrame(() => count.classList.add('is-changing'));
            }
            state?.classList.remove('is-loading', 'is-error');
            if (state) state.innerHTML = '<i class="fas fa-circle" aria-hidden="true"></i> Calcul à jour';
        } catch (_) {
            state?.classList.remove('is-loading');
            state?.classList.add('is-error');
            if (state) state.innerHTML = '<i class="fas fa-circle" aria-hidden="true"></i> Calcul indisponible';
        }
    };

    form.querySelectorAll('[data-audience-filter]').forEach((field) => {
        field.addEventListener('change', () => {
            window.clearTimeout(timer);
            timer = window.setTimeout(loadAudience, 220);
        });
        field.addEventListener('input', () => {
            if (field.tagName !== 'INPUT') return;
            window.clearTimeout(timer);
            timer = window.setTimeout(loadAudience, 350);
        });
    });

    updatePreview();
    if (form.querySelectorAll('[data-audience-filter]').length) loadAudience();
})();
