import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['toggle', 'panel'];

    toggle() {
        const isOpen = !this.panelTarget.hidden;
        this.panelTarget.hidden = isOpen;
        this.toggleTarget.setAttribute('aria-expanded', String(!isOpen));
    }

    closeOnClickOutside(event) {
        if (!this.element.contains(event.target)) {
            this.panelTarget.hidden = true;
            this.toggleTarget.setAttribute('aria-expanded', 'false');
        }
    }
}
