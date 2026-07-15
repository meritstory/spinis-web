import '../styles/tinymce-editor.css';
import { initTinyMceEditors } from '../shared/tinymce_editor.js';

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTinyMceEditors);
} else {
    initTinyMceEditors();
}
