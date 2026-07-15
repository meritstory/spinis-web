<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    'tinymce' => [
        'version' => '8.8.0',
    ],
    'admin/tinymce-field' => [
        'path' => './assets/admin/tinymce-field.js',
        'entrypoint' => true,
    ],
    'tinymce/icons/default' => [
        'version' => '8.8.0',
    ],
    'tinymce/models/dom' => [
        'version' => '8.8.0',
    ],
    'tinymce/themes/silver' => [
        'version' => '8.8.0',
    ],
    'tinymce/skins/ui/oxide/skin.js' => [
        'version' => '8.8.0',
    ],
    'tinymce/skins/ui/oxide/content.js' => [
        'version' => '8.8.0',
    ],
    'tinymce/skins/content/default/content.js' => [
        'version' => '8.8.0',
    ],
    'tinymce/plugins/advlist' => [
        'version' => '8.8.0',
    ],
    'tinymce/plugins/autoresize' => [
        'version' => '8.8.0',
    ],
    'tinymce/plugins/code' => [
        'version' => '8.8.0',
    ],
    'tinymce/plugins/link' => [
        'version' => '8.8.0',
    ],
    'tinymce/plugins/lists' => [
        'version' => '8.8.0',
    ],
    'tinymce/plugins/table' => [
        'version' => '8.8.0',
    ],
];
