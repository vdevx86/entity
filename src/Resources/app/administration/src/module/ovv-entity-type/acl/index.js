Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'content',
        key: 'ovv_entity_type',
        roles: {
            viewer: {
                privileges: [
                    'ovv_entity_type:read',
                ],

                dependencies: [
                    'ovv_entity.viewer',
                ],
            },

            editor: {
                privileges: [
                    'ovv_entity_type:update',
                ],

                dependencies: [
                    'ovv_entity_type.viewer',
                ],
            },

            creator: {
                privileges: [
                    'ovv_entity_type:create',
                ],

                dependencies: [
                    'ovv_entity_type.viewer',
                    'ovv_entity_type.editor',
                ],
            },

            deleter: {
                privileges: [
                    'ovv_entity_type:delete',
                ],

                dependencies: [
                    'ovv_entity_type.viewer',
                ],
            },
        },
    });
