import './acl';
import defaultSearchConfiguration from './default-search-configuration';

const { Module } = Shopware;

Shopware.Component.register('ovv-entity-media-form', () => import('./component/ovv-entity-media-form'));
Shopware.Component.register('ovv-entity-list', () => import('./page/ovv-entity-list'));
Shopware.Component.register('ovv-entity-detail', () => import('./page/ovv-entity-detail'));

Module.register('ovv-entity', {
    type: 'plugin',
    name: 'ovv-entity',
    title: 'ovv.entity.entity',
    description: 'ovv.entity.entityManage',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#ff68b4',
    icon: 'regular-content',
    entity: 'ovv_entity',

    routes: {
        index: {
            component: 'ovv-entity-list',
            path: 'index',

            meta: {
                privilege: 'ovv_entity.viewer',
            },
        },

        create: {
            component: 'ovv-entity-detail',
            path: 'create',

            meta: {
                parentPath: 'ovv.entity.index',
                privilege: 'ovv_entity.creator',
            }
        },

        detail: {
            component: 'ovv-entity-detail',
            path: 'detail/:id',

            meta: {
                parentPath: 'ovv.entity.index',
                privilege: 'ovv_entity.viewer',
            },
        },
    },

    navigation: [{
        id: 'ovv-entity',
        parent: 'sw-content',
        label: 'ovv.entity.entity',
        color: '#ff68b4',
        icon: 'regular-content',
        privilege: 'ovv_entity.viewer',
        position: 2050,
    }, {
        parent: 'ovv-entity',
        label: 'ovv.entity.entities',
        color: '#ff68b4',
        icon: 'regular-content',
        path: 'ovv.entity.index',
        privilege: 'ovv_entity.viewer',
        position: 100,
    }],

    defaultSearchConfiguration,
});
