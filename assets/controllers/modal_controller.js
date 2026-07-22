import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['panel'];

    connect() {
        this.panelTarget.focus();
    }

    close() {
        this.element.remove();
    }

    closeOnBackdropClick(event) {
        if (event.target === this.element) {
            this.close();
        }
    }

    keydown(event) {
        if (event.key === 'Escape') {
            this.close();

            return;
        }

        if (event.key === 'Tab') {
            this.trapFocus(event);
        }
    }

    trapFocus(event) {
        const focusable = this.panelTarget.querySelectorAll('a[href], button:not([disabled])');
        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }
}
