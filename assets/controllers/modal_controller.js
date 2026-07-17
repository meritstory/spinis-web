import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    close() {
        this.element.remove();
    }

    closeOnBackdropClick(event) {
        if (event.target === this.element) {
            this.close();
        }
    }
}
