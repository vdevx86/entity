import './acl';
import defaultSearchConfiguration from './default-search-configuration';

const { Module } = Shopware;

Shopware.Component.register('ovv-entity-template-list', () => import('./page/ovv-entity-template-list'));
Shopware.Component.register('ovv-entity-template-detail', () => import('./page/ovv-entity-template-detail'));

Module.register('ovv-entity-template', {
    type: 'plugin',
    name: 'ovv-entity-template',
    title: 'ovv.entityTemplate.entity',
    description: 'ovv.entityTemplate.entityManage',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#ff68b4',
    icon: 'regular-content',
    entity: 'ovv_entity_template',

    routes: {
        index: {
            component: 'ovv-entity-template-list',
            path: 'index',

            meta: {
                privilege: 'ovv_entity_template.viewer',
            },
        },

        create: {
            component: 'ovv-entity-template-detail',
            path: 'create',

            meta: {
                parentPath: 'ovv.entity.template.index',
                privilege: 'ovv_entity_template.creator',
            }
        },

        detail: {
            component: 'ovv-entity-template-detail',
            path: 'detail/:id',

            meta: {
                parentPath: 'ovv.entity.template.index',
                privilege: 'ovv_entity_template.viewer',
            },
        },
    },

    navigation: [{
        parent: 'ovv-entity',
        label: 'ovv.entityTemplate.templates',
        color: '#ff68b4',
        icon: 'regular-content',
        path: 'ovv.entity.template.index',
        privilege: 'ovv_entity_template.viewer',
        position: 300,
    }],

    defaultSearchConfiguration,
});
