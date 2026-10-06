(() => {
    const form = document.getElementById('pgdeCampaignForm');
    if (!form) return;

    const count = document.getElementById('pgdeAudienceCount');
    const state = document.getElementById('pgdeAudienceState');
    const subject = form.querySelector('[data-campaign-subject]');
    const body = form.querySelector('[data-campaign-body]');
    const previewSubject = document.querySelector('[data-preview-subject]');
    const previewBody = document.querySelector('[data-preview-body]');
    const stepPanels = Array.from(form.querySelectorAll('[data-comms-step-panel]'));
    const stepTabs = Array.from(form.querySelectorAll('[data-comms-step-target]'));
    const filterFields = Array.from(form.querySelectorAll('[data-audience-filter]'));
    const filterChips = document.getElementById('pgdeCommsFilterChips');
    const clearFiltersButton = form.querySelector('[data-clear-audience-filters]');
    let timer;

    form.classList.add('has-stepper');
    form.noValidate = true;

    const activateStep = (stepIndex) => {
        stepPanels.forEach((panel, index) => {
            const active = index === stepIndex;
            panel.classList.toggle('is-active', active);
            panel.setAttribute('aria-hidden', String(!active));
        });
        stepTabs.forEach((tab, index) => {
            const active = index === stepIndex;
            tab.classList.toggle('is-active', active);
            tab.setAttribute('aria-selected', String(active));
            tab.tabIndex = active ? 0 : -1;
        });
    };

    stepTabs.forEach((tab, index) => {
        tab.addEventListener('click', () => activateStep(Number(tab.dataset.commsStepTarget)));
        tab.addEventListener('keydown', (event) => {
            if (!['ArrowRight', 'ArrowLeft', 'Home', 'End'].includes(event.key)) return;
            event.preventDefault();
            const nextIndex = event.key === 'Home' ? 0
                : event.key === 'End' ? stepTabs.length - 1
                : (index + (event.key === 'ArrowRight' ? 1 : -1) + stepTabs.length) % stepTabs.length;
            activateStep(nextIndex);
            stepTabs[nextIndex]?.focus();
        });
    });
    form.querySelectorAll('[data-comms-next]').forEach((button) => button.addEventListener('click', () => {
        const targetStep = Number(button.dataset.commsNext);
        const messagePanel = form.querySelector('[data-comms-step-panel="1"]');
        if (targetStep === 2 && messagePanel) {
            const requiredFields = Array.from(messagePanel.querySelectorAll('[required]'));
            const firstInvalid = requiredFields.find((field) => !field.checkValidity());
            if (firstInvalid) {
                activateStep(1);
                requestAnimationFrame(() => firstInvalid.reportValidity());
                return;
            }
        }
        activateStep(targetStep);
    }));
    form.querySelectorAll('[data-comms-prev]').forEach((button) => button.addEventListener('click', () => activateStep(Number(button.dataset.commsPrev))));
    form.addEventListener('submit', (event) => {
        const requiredFields = Array.from(form.querySelectorAll('[required]'));
        const firstInvalid = requiredFields.find((field) => !field.checkValidity());
        if (!firstInvalid) return;
        event.preventDefault();
        const fieldPanel = firstInvalid.closest('[data-comms-step-panel]');
        activateStep(Number(fieldPanel?.dataset.commsStepPanel || 0));
        requestAnimationFrame(() => firstInvalid.reportValidity());
    });

    const updateFilterChips = () => {
        if (!filterChips) return;
        const activeFilters = filterFields.filter((field) => field.value !== '');
        filterChips.replaceChildren();
        if (clearFiltersButton) clearFiltersButton.hidden = activeFilters.length === 0;
        if (!activeFilters.length) {
            const empty = document.createElement('span');
            empty.className = 'pgde-comms-no-filters';
            empty.textContent = 'Aucun critère supplémentaire';
            filterChips.appendChild(empty);
            return;
        }
        activeFilters.forEach((field) => {
            const label = field.closest('.pgde-comms-field')?.querySelector('span')?.textContent.trim() || 'Critère';
            const value = field.tagName === 'SELECT'
                ? field.options[field.selectedIndex]?.textContent.trim()
                : field.value;
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'pgde-comms-filter-chip';
            chip.setAttribute('aria-label', `Retirer le critère ${label}`);
            const chipText = document.createElement('span');
            chipText.textContent = `${label} : ${value}`;
            const removeIcon = document.createElement('i');
            removeIcon.className = 'fas fa-times';
            removeIcon.setAttribute('aria-hidden', 'true');
            chip.append(chipText, removeIcon);
            chip.addEventListener('click', () => {
                field.value = '';
                field.dispatchEvent(new Event('change', { bubbles: true }));
            });
            filterChips.appendChild(chip);
        });
    };

    clearFiltersButton?.addEventListener('click', () => {
        filterFields.forEach((field) => { field.value = ''; });
        updateFilterChips();
        window.clearTimeout(timer);
        loadAudience();
    });

    const updatePreview = () => {
        if (previewSubject) previewSubject.textContent = subject?.value.trim() || 'Objet de votre e-mail';
        if (previewBody) previewBody.textContent = body?.value.trim() || 'Votre message apparaîtra ici au fur et à mesure de votre rédaction.';
    };

    subject?.addEventListener('input', updatePreview);
    body?.addEventListener('input', updatePreview);

    const loadAudience = async () => {
        const params = new URLSearchParams();
        filterFields.forEach((field) => {
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

    filterFields.forEach((field) => {
        field.addEventListener('change', () => {
            updateFilterChips();
            window.clearTimeout(timer);
            timer = window.setTimeout(loadAudience, 220);
        });
        field.addEventListener('input', () => {
            if (field.tagName !== 'INPUT') return;
            updateFilterChips();
            window.clearTimeout(timer);
            timer = window.setTimeout(loadAudience, 350);
        });
    });

    updatePreview();
    updateFilterChips();
    activateStep(0);
    if (filterFields.length) loadAudience();

    const sendDialog = document.getElementById('pgdeCommsSendDialog');
    let pendingSendForm = null;
    document.querySelectorAll('[data-comms-send-form]').forEach((sendForm) => {
        sendForm.addEventListener('submit', (event) => {
            event.preventDefault();
            pendingSendForm = sendForm;
            document.getElementById('pgdeCommsSendName').textContent = sendForm.dataset.sendName || '—';
            document.getElementById('pgdeCommsSendSubject').textContent = sendForm.dataset.sendSubject || '—';
            document.getElementById('pgdeCommsSendCount').textContent = `${new Intl.NumberFormat('fr-FR').format(Number(sendForm.dataset.sendCount || 0))} destinataire(s)`;
            document.getElementById('pgdeCommsSendBody').textContent = sendForm.dataset.sendBody || 'Aucun aperçu disponible.';
            sendDialog?.showModal();
        });
    });
    document.getElementById('pgdeCommsConfirmSend')?.addEventListener('click', () => pendingSendForm?.submit());
})();
