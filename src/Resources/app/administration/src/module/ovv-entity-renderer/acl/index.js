Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'content',
        key: 'ovv_entity_renderer',
        roles: {
            viewer: {
                privileges: [
                    'ovv_entity_renderer:read',
                    'ovv_entity_template:read',
                    'ovv_entity_renderer_entity_type:create',
                    'ovv_entity_renderer_entity_type:delete',
                    'ovv_entity_renderer_entity:create',
                    'ovv_entity_renderer_entity:delete',
                ],

                dependencies: [
                    'ovv_entity.viewer',
                    'ovv_entity_type.viewer',
                    'ovv_entity_template.viewer',
                ],
            },

            editor: {
                privileges: [
                    'ovv_entity_renderer:update',
                ],

                dependencies: [
                    'ovv_entity_renderer.viewer',
                ],
            },

            creator: {
                privileges: [
                    'ovv_entity_renderer:create',
                ],

                dependencies: [
                    'ovv_entity_renderer.viewer',
                    'ovv_entity_renderer.editor',
                ],
            },

            deleter: {
                privileges: [
                    'ovv_entity_renderer:delete',
                ],

                dependencies: [
                    'ovv_entity_renderer.viewer',
                ],
            },
        },
    });
