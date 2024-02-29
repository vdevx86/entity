import './acl';
import defaultSearchConfiguration from './default-search-configuration';

const { Module } = Shopware;

Shopware.Component.register('ovv-entity-renderer-list', () => import('./page/ovv-entity-renderer-list'));
Shopware.Component.register('ovv-entity-renderer-detail', () => import('./page/ovv-entity-renderer-detail'));

Module.register('ovv-entity-renderer', {
    type: 'plugin',
    name: 'ovv-entity-renderer',
    title: 'ovv.entityRenderer.entity',
    description: 'ovv.entityRenderer.entityManage',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#ff68b4',
    icon: 'regular-content',
    entity: 'ovv_entity_renderer',

    routes: {
        index: {
            component: 'ovv-entity-renderer-list',
            path: 'index',

            meta: {
                privilege: 'ovv_entity_renderer.viewer',
            },
        },

        create: {
            component: 'ovv-entity-renderer-detail',
            path: 'create',

            meta: {
                parentPath: 'ovv.entity.renderer.index',
                privilege: 'ovv_entity_renderer.creator',
            }
        },

        detail: {
            component: 'ovv-entity-renderer-detail',
            path: 'detail/:id',

            meta: {
                parentPath: 'ovv.entity.renderer.index',
                privilege: 'ovv_entity_renderer.viewer',
            },
        },
    },

    navigation: [{
        parent: 'ovv-entity',
        label: 'ovv.entityRenderer.renderers',
        color: '#ff68b4',
        icon: 'regular-content',
        path: 'ovv.entity.renderer.index',
        privilege: 'ovv_entity_renderer.viewer',
        position: 400,
    }],

    defaultSearchConfiguration,
});
