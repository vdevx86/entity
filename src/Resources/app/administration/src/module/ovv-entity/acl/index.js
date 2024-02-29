Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'content',
        key: 'ovv_entity',
        roles: {
            viewer: {
                privileges: [
                    'sales_channel:read',
                    'currency:read',
                    Shopware.Service('privileges').getPrivileges('media.viewer'),
                    'ovv_entity:read',
                    'ovv_entity_type:read',
                    'ovv_entity_media:read',
                ],

                dependencies: [
                ],
            },

            editor: {
                privileges: [
                    'ovv_entity:update',
                    Shopware.Service('privileges').getPrivileges('media.creator'),
                    'ovv_entity_media:delete',
                ],

                dependencies: [
                    'ovv_entity.viewer',
                ],
            },

            creator: {
                privileges: [
                    'ovv_entity:create',
                ],

                dependencies: [
                    'ovv_entity.viewer',
                    'ovv_entity.editor',
                ],
            },

            deleter: {
                privileges: [
                    'ovv_entity:delete',
                ],

                dependencies: [
                    'ovv_entity.viewer',
                ],
            },
        },
    });
