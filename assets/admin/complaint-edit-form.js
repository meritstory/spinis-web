function clearDirtyFormWarning() {
    window.onbeforeunload = null;
}

const CONFIRM_BUTTON_VARIANT_CLASSES = [
    'btn-secondary',
    'btn-primary',
    'btn-success',
    'btn-warning',
    'btn-danger',
];

function setComplaintConfirmButtonVariant(modalButton, variant) {
    const variantToClass = {
        default: 'btn-secondary',
        primary: 'btn-primary',
        danger: 'btn-danger',
    };
    const className = variantToClass[variant] ?? variantToClass.default;
    modalButton.classList.remove(...CONFIRM_BUTTON_VARIANT_CLASSES);
    modalButton.classList.add(className);
}

function complaintConfirmVariantForAction(actionElement) {
    if (actionElement.classList.contains('action-cancelChanges')) {
        return 'danger';
    }

    if (
        actionElement.classList.contains('action-saveAndReturn')
        || actionElement.classList.contains('action-saveAndContinue')
    ) {
        return 'primary';
    }

    return 'default';
}

function initComplaintEditConfirmedActions() {
    if (document.querySelector('form.ea-edit-form') === null) {
        return;
    }

    let pendingActionElement = null;
    const confirmationModal = document.getElementById('modal-action-confirmation');

    document.querySelectorAll('[data-action-confirmation="true"]').forEach((actionElement) => {
        actionElement.addEventListener(
            'click',
            () => {
                pendingActionElement = actionElement;

                if (confirmationModal === null) {
                    return;
                }

                confirmationModal.addEventListener(
                    'shown.bs.modal',
                    () => {
                        const modalButton = document.getElementById('modal-action-confirmation-button');
                        if (modalButton === null || pendingActionElement === null) {
                            return;
                        }

                        setComplaintConfirmButtonVariant(
                            modalButton,
                            complaintConfirmVariantForAction(pendingActionElement),
                        );
                    },
                    { once: true },
                );
            },
            true,
        );
    });

    const modalButton = document.getElementById('modal-action-confirmation-button');
    if (modalButton === null) {
        return;
    }

    modalButton.addEventListener(
        'click',
        (event) => {
            const actionElement = pendingActionElement;
            pendingActionElement = null;
            if (actionElement === null) {
                return;
            }

            const href = actionElement.getAttribute('href');
            if (href !== null && href !== '' && href !== '#') {
                clearDirtyFormWarning();
                event.stopImmediatePropagation();
                window.location.assign(href);

                return;
            }

            const formId = actionElement.getAttribute('form');
            if (formId === null || formId === '') {
                return;
            }

            const form = document.getElementById(formId);
            if (form === null) {
                return;
            }

            clearDirtyFormWarning();
            event.stopImmediatePropagation();
            form.requestSubmit(actionElement);
        },
        true,
    );
}

document.addEventListener('DOMContentLoaded', initComplaintEditConfirmedActions);
