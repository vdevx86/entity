import template from './ovv-entity-renderer-detail.html.twig';
import './ovv-entity-renderer-detail.scss';

const { Criteria } = Shopware.Data;
const { mapPropertyErrors } = Shopware.Component.getComponentHelper();

export default {
    template,

    inject: [ 'acl', 'repositoryFactory' ],

    mixins: [
        'placeholder',
    ],

    shortcuts: {
        'SYSTEMKEY+S': {
            active() {
                return this.canEdit;
            },

            method: 'onSave',
        },

        ESCAPE: 'onCancel',
    },

    data() {
        return {
            isLoading: false,
            isSaveSuccessful: false,
            entity: null,
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    computed: {
        context() {
            return { ...Shopware.Context.api, inheritance: true };
        },

        isLoaded() {
            return !this.isLoading && this.entity !== null;
        },

        canEdit() {
            return this.aclCan('editor') && this.isLoaded;
        },

        canSave() {
            const canEdit = this.canEdit;

            if (!canEdit) {
                return false;
            }

            return !!this.entity.name;
        },

        canSaveEdit() {
            return this.canSave && !this.isNew;
        },

        isNew() {
            return !!this.entity.isNew && this.entity.isNew();
        },

        repository() {
            return this.repositoryFactory.create('ovv_entity_renderer');
        },

        title() {
            if (!this.isLoaded) {
                return null;
            }

            const name = this.entity.name || this.entity.translated?.name || null;

            if (!name && this.isNew) {
                return this.t('entityNew');
            }

            return name;
        },

        cardIdIsVisible() {
            return this.isLoaded && !this.isNew;
        },

        typeColumns() {
            return [{
                property: 'autoIncrement',
                label: 'ID',
                primary: true,
                allowResize: true,
                dataIndex: 'autoIncrement',
                sortable: false,
                width: '150px',
            }, {
                property: 'name',
                label: this.t('name'),
                allowResize: true,
                routerLink: 'ovv.entity.type.index',
                sortable: false,
            }];
        },

        entityColumns() {
            return [{
                property: 'autoIncrement',
                label: 'ID',
                primary: true,
                allowResize: true,
                dataIndex: 'autoIncrement',
                sortable: false,
                width: '150px',
            }, {
                property: 'name',
                label: this.t('name'),
                allowResize: true,
                routerLink: 'ovv.entity.index',
                sortable: false,
            }];
        },

        ...mapPropertyErrors('entity', [
            'name',
            'slug',
            'description',
        ]),
    },

    watch: {
        '$route.params.id'() {
            this.createdComponent();
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        t(value) {
            return this.$tc(`ovv.entityRenderer.${value}`);
        },

        aclCan(value) {
            return this.acl.can(`ovv_entity_renderer.${value}`);
        },

        createRepository() {
            return this.repository.create(this.context);
        },

        createdComponent() {
            Shopware.State.commit('context/resetLanguageToDefault');

            if (this.$route.params.id) {
                this.loadEntityData(this.$route.params.id);
            } else {
                this.entity = this.createRepository();
            }
        },

        loadEntityData(entityId) {
            this.isLoading = true;

            const criteria = new Criteria(1, 1);

            return this.repository.get(entityId, this.context, criteria).then((entity) => {
                this.entity = !entity ? this.createRepository() : entity;
            }).finally(() => {
                this.isLoading = false;
            });
        },

        onSave() {
            if (!this.canSave) {
                return;
            }

            this.isLoading = true;
            this.isSaveSuccessful = false;

            const isNew = this.entity.isNew();

            this.repository.save(this.entity, this.context).then(() => {
                if (isNew) {
                    this.$router.push({ name: 'ovv.entity.renderer.detail', params: { id: this.entity.id } });
                } else {
                    this.loadEntityData(this.entity.id).then(() => {
                        this.isSaveSuccessful = true;
                    });
                }
            }).finally(() => {
                this.isLoading = false;
            });
        },

        onSaveFinish() {
            this.isSaveSuccessful = false;
        },

        onCancel() {
            this.$router.push({ name: 'ovv.entity.renderer.index' });
        },

        pholder(field) {
            return this.placeholder(this.entity, field, this.t('placeholder.' + field));
        },
    },
};
