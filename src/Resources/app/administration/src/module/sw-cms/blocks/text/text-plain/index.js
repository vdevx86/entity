Shopware.Component.register('sw-cms-preview-text-plain', () => import('./preview'));
Shopware.Component.register('sw-cms-block-text-plain', () => import('./component'));

Shopware.Service('cmsService').registerCmsBlock({
    name: 'text-plain',
    label: 'sw-cms.plainText',
    category: 'text',

    component: 'sw-cms-block-text-plain',
    previewComponent: 'sw-cms-preview-text-plain',

    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
    },

    slots: {
        content: 'text-plain',
    },
});
