Shopware.Component.register('sw-cms-el-preview-text-plain', () => import('./preview'));
Shopware.Component.register('sw-cms-el-config-text-plain', () => import('./config'));
Shopware.Component.register('sw-cms-el-text-plain', () => import('./component'));

Shopware.Service('cmsService').registerCmsElement({
    name: 'text-plain',
    label: 'sw-cms.plainText',

    component: 'sw-cms-el-text-plain',
    configComponent: 'sw-cms-el-config-text-plain',
    previewComponent: 'sw-cms-el-preview-text-plain',

    defaultConfig: {
        content: {
            source: 'static',
            value: 'Lorem Ipsum dolor sit amet',
        },
    },
});
