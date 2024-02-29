const { Component } = Shopware;

Component.override('sw-desktop', {
    inject: [ 'customFieldDataProviderService' ],

    methods: {
        createdComponent() {
            this.$super('createdComponent');

            this.customFieldDataProviderService.addEntityName('ovv_entity');
        },
    }
});
