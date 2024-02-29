import './acl';
import defaultSearchConfiguration from './default-search-configuration';

const { Module } = Shopware;

Shopware.Component.register('ovv-entity-type-list', () => import('./page/ovv-entity-type-list'));
Shopware.Component.register('ovv-entity-type-detail', () => import('./page/ovv-entity-type-detail'));

Module.register('ovv-entity-type', {
    type: 'plugin',
    name: 'ovv-entity-type',
    title: 'ovv.entityType.entity',
    description: 'ovv.entityType.entityManage',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#ff68b4',
    icon: 'regular-content',
    entity: 'ovv_entity_type',

    routes: {
        index: {
            component: 'ovv-entity-type-list',
            path: 'index',

            meta: {
                privilege: 'ovv_entity_type.viewer',
            },
        },

        create: {
            component: 'ovv-entity-type-detail',
            path: 'create',

            meta: {
                parentPath: 'ovv.entity.type.index',
                privilege: 'ovv_entity_type.creator',
            }
        },

        detail: {
            component: 'ovv-entity-type-detail',
            path: 'detail/:id',

            meta: {
                parentPath: 'ovv.entity.type.index',
                privilege: 'ovv_entity_type.viewer',
            },
        },
    },

    navigation: [{
        parent: 'ovv-entity',
        label: 'ovv.entityType.types',
        color: '#ff68b4',
        icon: 'regular-content',
        path: 'ovv.entity.type.index',
        privilege: 'ovv_entity_type.viewer',
        position: 200,
    }],

    defaultSearchConfiguration,
});
