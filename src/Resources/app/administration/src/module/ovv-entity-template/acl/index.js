Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'content',
        key: 'ovv_entity_template',
        roles: {
            viewer: {
                privileges: [
                    'ovv_entity_template:read',
                ],

                dependencies: [
                    'ovv_entity.viewer',
                ],
            },

            editor: {
                privileges: [
                    'ovv_entity_template:update',
                ],

                dependencies: [
                    'ovv_entity_template.viewer',
                ],
            },

            creator: {
                privileges: [
                    'ovv_entity_template:create',
                ],

                dependencies: [
                    'ovv_entity_template.viewer',
                    'ovv_entity_template.editor',
                ],
            },

            deleter: {
                privileges: [
                    'ovv_entity_template:delete',
                ],

                dependencies: [
                    'ovv_entity_template.viewer',
                ],
            },
        },
    });
