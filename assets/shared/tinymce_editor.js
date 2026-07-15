import 'tinymce';
import 'tinymce/icons/default';
import 'tinymce/models/dom';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autoresize';
import 'tinymce/plugins/code';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/table';
import 'tinymce/skins/content/default/content.js';
import 'tinymce/skins/ui/oxide/content.js';
import 'tinymce/skins/ui/oxide/skin.js';
import 'tinymce/themes/silver';

function ensureEditorId(textarea) {
    if (textarea.id) {
        return textarea.id;
    }

    const generatedId = `tinymce-editor-${crypto.randomUUID()}`;
    textarea.id = generatedId;

    return generatedId;
}

function syncEditorContent(editor) {
    editor.save();
}

function resolveInitialMinHeight(textarea) {
    const rows = Number.parseInt(textarea.getAttribute('rows') ?? '2', 10);
    const safeRows = Number.isNaN(rows) || rows <= 0 ? 2 : rows;

    return safeRows * 24;
}

function resolveContentStyle(isReadOnly) {
    const fontStyle = 'body { font-family: Calibri, sans-serif; }';

    if (!isReadOnly) {
        return fontStyle;
    }

    return `${fontStyle} body { caret-color: transparent; cursor: default; }`;
}

function triggerInitialResize(editor) {
    if (!editor.hasPlugin('autoresize')) {
        return;
    }

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            editor.execCommand('mceAutoResize');
        });
    });
}

export function initTinyMceEditors() {
    const tinymce = window.tinymce;
    if (!tinymce) {
        console.error('TinyMCE is not loaded.');

        return;
    }

    const textareas = Array.from(document.querySelectorAll('textarea[data-tinymce-editor="true"]'));
    if (textareas.length === 0) {
        return;
    }

    textareas.forEach((textarea) => {
        ensureEditorId(textarea);

        const existingEditor = tinymce.get(textarea.id);
        if (existingEditor) {
            return;
        }

        const isReadOnly = textarea.disabled || textarea.dataset.tinymceReadonly === '1';

        tinymce.init({
            target: textarea,
            license_key: 'gpl',
            language: 'lt',
            language_url: '/tinymce/langs/lt.js',
            language_load: false,
            branding: false,
            promotion: false,
            menubar: false,
            statusbar: false,
            elementpath: false,
            readonly: isReadOnly,
            browser_spellcheck: false,
            contextmenu: false,
            plugins: 'advlist autoresize code link lists table',
            min_height: resolveInitialMinHeight(textarea),
            resize: false,
            autoresize_bottom_margin: 16,
            content_style: resolveContentStyle(isReadOnly),
            toolbar: isReadOnly
                ? false
                : 'undo redo | blocks | fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | blockquote link table code | removeformat',
            fontsize_formats: '12px 14px 16px 18px 24px',
            block_formats: 'Pastraipa=p; Antraštė 1=h1; Antraštė 2=h2; Antraštė 3=h3',
            setup: (editor) => {
                editor.on('init', () => {
                    textarea.dataset.tinymceInitialized = '1';

                    if (textarea.classList.contains('is-invalid')) {
                        editor.getContainer()?.classList.add('tinymce-editor-invalid');
                    }

                    if (isReadOnly) {
                        textarea.setAttribute('disabled', 'disabled');
                    }
                });

                if (!isReadOnly) {
                    editor.on('change input undo redo', () => {
                        syncEditorContent(editor);
                    });
                }
            },
            init_instance_callback: (editor) => {
                triggerInitialResize(editor);

                if (!isReadOnly && textarea.form) {
                    if (textarea.dataset.tinymceSubmitBound !== '1') {
                        textarea.form.addEventListener('submit', () => {
                            tinymce.triggerSave();
                        });

                        textarea.dataset.tinymceSubmitBound = '1';
                    }
                }
            },
        });
    });
}
