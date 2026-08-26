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

const colorMenuContext = {
    editorId: null,
    bookmark: null,
    format: null,
};

const editorsWithOutsideClear = new Set();

let documentInteractionHandlersBound = false;

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
    const blurredSelectionStyle = 'body:not(.is-focused)::selection, body:not(.is-focused) ::selection { background-color: transparent; }';
    const baseStyle = `${fontStyle} ${blurredSelectionStyle}`;

    if (!isReadOnly) {
        return baseStyle;
    }

    return `${baseStyle} body { caret-color: transparent; cursor: default; }`;
}

function getTinyMce() {
    return window.tinymce ?? null;
}

function getEditorById(editorId) {
    const tinymce = getTinyMce();
    if (!tinymce || editorId === null) {
        return null;
    }

    return tinymce.get(editorId) ?? null;
}

function isTargetInsideEditorUi(target, editor) {
    if (!(target instanceof Node)) {
        return false;
    }

    const container = editor.getContainer();
    if (container?.contains(target)) {
        return true;
    }

    return target instanceof Element && target.closest('.tox-tinymce-aux') !== null;
}

function hasOpenEditorUiPopup() {
    return Array.from(document.querySelectorAll('.tox-tinymce-aux')).some((aux) => {
        return aux.querySelector('.tox-menu:not(.tox-menu--disabled), .tox-pop, .tox-dialog') !== null;
    });
}

function shouldPreserveEditorSelection(editor, eventTarget = null) {
    if (isTargetInsideEditorUi(eventTarget ?? document.activeElement, editor)) {
        return true;
    }

    return hasOpenEditorUiPopup();
}

function isEditorSelectionAvailable(editor) {
    return editor.getBody() !== null && editor.getWin() !== null;
}

function collapseEditorSelection(editor) {
    if (!isEditorSelectionAvailable(editor)) {
        return;
    }

    try {
        editor.selection.collapse(false);
        editor.nodeChanged();
    } catch {
        return;
    }
}

function clearEditorSelection(editor) {
    editor.getBody()?.classList.remove('is-focused');
    collapseEditorSelection(editor);
    editor.getWin()?.getSelection()?.removeAllRanges();
}

function clearEditorSelectionIfOutsideUi(editor, eventTarget) {
    if (isTargetInsideEditorUi(eventTarget, editor)) {
        return;
    }

    clearEditorSelection(editor);
}

function clearEditorSelectionIfNeeded(editor) {
    if (shouldPreserveEditorSelection(editor)) {
        return;
    }

    clearEditorSelection(editor);
}

function scheduleClearEditorSelectionIfNeeded(editor) {
    window.setTimeout(() => {
        clearEditorSelectionIfNeeded(editor);
    }, 0);
}

function handleOutsideEditorInteraction(event) {
    for (const editor of editorsWithOutsideClear) {
        clearEditorSelectionIfOutsideUi(editor, event.target);
    }
}

function bindOutsideInteractionClear(editor) {
    editorsWithOutsideClear.add(editor);

    editor.on('remove', () => {
        editorsWithOutsideClear.delete(editor);
    });
}

function captureColorMenuContext(editor, format) {
    colorMenuContext.editorId = editor.id;
    colorMenuContext.format = format;
    colorMenuContext.bookmark = null;

    if (!isEditorSelectionAvailable(editor)) {
        return;
    }

    try {
        colorMenuContext.bookmark = editor.selection.getBookmark(2);
    } catch {
        colorMenuContext.bookmark = null;
    }
}

function clearColorMenuContext() {
    colorMenuContext.editorId = null;
    colorMenuContext.bookmark = null;
    colorMenuContext.format = null;
}

function restoreColorMenuSelection(editor) {
    if (colorMenuContext.editorId !== editor.id || colorMenuContext.bookmark === null) {
        return;
    }

    if (!isEditorSelectionAvailable(editor)) {
        return;
    }

    try {
        editor.selection.moveToBookmark(colorMenuContext.bookmark);
    } catch {
        return;
    }
}

function resolveColorMenuEditor() {
    return getEditorById(colorMenuContext.editorId);
}

function resolveOpenColorFormat() {
    if (document.querySelector('[aria-label="Background color menu"][aria-expanded="true"]') !== null) {
        return 'hilitecolor';
    }

    if (document.querySelector('[aria-label="Text color menu"][aria-expanded="true"]') !== null) {
        return 'forecolor';
    }

    return colorMenuContext.format;
}

function resolveOpenSwatchMenu() {
    return document.querySelector('.tox-swatches-menu');
}

function isPointerInsideRect(clientX, clientY, rect) {
    return clientX >= rect.left && clientX <= rect.right && clientY >= rect.top && clientY <= rect.bottom;
}

function getSwatchHitRect(swatch) {
    const transformedRect = swatch.getBoundingClientRect();
    const layoutWidth = swatch.offsetWidth;
    const layoutHeight = swatch.offsetHeight;

    if (layoutWidth === 0 || layoutHeight === 0) {
        return transformedRect;
    }

    const centerX = transformedRect.left + transformedRect.width / 2;
    const centerY = transformedRect.top + transformedRect.height / 2;

    return {
        left: centerX - layoutWidth / 2,
        right: centerX + layoutWidth / 2,
        top: centerY - layoutHeight / 2,
        bottom: centerY + layoutHeight / 2,
    };
}

function isPointerInsideSwatch(swatch, clientX, clientY) {
    return isPointerInsideRect(clientX, clientY, getSwatchHitRect(swatch));
}

function isSwatchPickerButton(target) {
    return target instanceof Element && target.closest('.tox-swatches__picker-btn') !== null;
}

function resolveSwatchAtPoint(menu, clientX, clientY) {
    const hoveredSwatches = [...menu.querySelectorAll('.tox-swatch:hover')]
        .filter((swatch) => !swatch.classList.contains('tox-swatches__picker-btn'));

    for (const swatch of hoveredSwatches) {
        if (isPointerInsideSwatch(swatch, clientX, clientY)) {
            return swatch;
        }
    }

    if (hoveredSwatches.length === 1) {
        const hovered = hoveredSwatches[0];
        const row = hovered.closest('.tox-swatches__row');

        if (row !== null && isPointerInsideRect(clientX, clientY, row.getBoundingClientRect())) {
            return hovered;
        }
    }

    for (const swatch of menu.querySelectorAll('.tox-swatch')) {
        if (swatch.classList.contains('tox-swatches__picker-btn')) {
            continue;
        }

        if (isPointerInsideSwatch(swatch, clientX, clientY)) {
            return swatch;
        }
    }

    return null;
}

function resolveSwatchFromPointerEvent(event, menu) {
    if (!(event.target instanceof Element)) {
        return resolveSwatchAtPoint(menu, event.clientX, event.clientY);
    }

    if (isSwatchPickerButton(event.target)) {
        return null;
    }

    const directSwatch = event.target.closest('.tox-swatch');
    if (directSwatch !== null && !directSwatch.classList.contains('tox-swatches__picker-btn')) {
        return directSwatch;
    }

    return resolveSwatchAtPoint(menu, event.clientX, event.clientY);
}

function resolveSwatchMenuInteraction(event) {
    if (!(event.target instanceof Node) || event.button !== 0) {
        return null;
    }

    const menu = resolveOpenSwatchMenu();
    if (menu === null) {
        return null;
    }

    const { clientX, clientY } = event;
    if (!isPointerInsideRect(clientX, clientY, menu.getBoundingClientRect())) {
        return null;
    }

    if (isSwatchPickerButton(event.target)) {
        return null;
    }

    const swatch = resolveSwatchFromPointerEvent(event, menu);
    if (swatch === null) {
        return null;
    }

    return { menu, swatch };
}

function applySwatchColor(editor, swatch, format) {
    restoreColorMenuSelection(editor);

    if (swatch.classList.contains('tox-swatch--remove')) {
        editor.undoManager.transact(() => {
            editor.formatter.remove(format, { value: null }, undefined, true);
            editor.nodeChanged();
        });

        syncEditorContent(editor);
        clearColorMenuContext();

        return;
    }

    const color = swatch.getAttribute('data-mce-color');
    if (color === null || color === '') {
        return;
    }

    editor.undoManager.transact(() => {
        editor.formatter.apply(format, { value: color });
        editor.nodeChanged();
    });

    syncEditorContent(editor);
    clearColorMenuContext();
}

function stopSwatchMenuEvent(event) {
    event.preventDefault();
    event.stopImmediatePropagation();
}

function tryApplyColorFromSwatchMenu(event) {
    const interaction = resolveSwatchMenuInteraction(event);
    if (interaction === null) {
        return false;
    }

    const editor = resolveColorMenuEditor();
    const format = resolveOpenColorFormat();
    if (editor === null || format === null) {
        return false;
    }

    stopSwatchMenuEvent(event);
    applySwatchColor(editor, interaction.swatch, format);

    return true;
}

function handleColorMenuButtonMouseDown(event) {
    if (!(event.target instanceof Element)) {
        return;
    }

    const editor = getTinyMce()?.activeEditor ?? null;
    if (editor === null) {
        return;
    }

    if (event.target.closest('[aria-label="Background color menu"]') !== null) {
        captureColorMenuContext(editor, 'hilitecolor');

        return;
    }

    if (event.target.closest('[aria-label="Text color menu"]') !== null) {
        captureColorMenuContext(editor, 'forecolor');
    }
}

function blockSwatchMenuClickThrough(event) {
    if (resolveSwatchMenuInteraction(event) === null) {
        return;
    }

    stopSwatchMenuEvent(event);
}

function bindDocumentInteractionHandlers() {
    if (documentInteractionHandlersBound) {
        return;
    }

    document.addEventListener('mousedown', handleColorMenuButtonMouseDown, true);
    document.addEventListener('mousedown', blockSwatchMenuClickThrough, true);
    document.addEventListener('mouseup', tryApplyColorFromSwatchMenu, true);
    document.addEventListener('mousedown', handleOutsideEditorInteraction, true);
    document.addEventListener('focusin', handleOutsideEditorInteraction, true);

    documentInteractionHandlersBound = true;
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
    const tinymce = getTinyMce();
    if (!tinymce) {
        console.error('TinyMCE is not loaded.');

        return;
    }

    bindDocumentInteractionHandlers();

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
                editor.on('focus', () => {
                    editor.getBody()?.classList.add('is-focused');
                });

                editor.on('blur', () => {
                    scheduleClearEditorSelectionIfNeeded(editor);
                });

                editor.on('deactivate', () => {
                    scheduleClearEditorSelectionIfNeeded(editor);
                });

                if (!isReadOnly) {
                    bindOutsideInteractionClear(editor);
                }

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
