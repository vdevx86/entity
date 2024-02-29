import template from './ovv-entity-template-detail.html.twig';
import './ovv-entity-template-detail.scss';

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

            if (!this.isDefaultLanguage) {
                return true;
            }

            return !!this.entity.name;
        },

        canSwitchLanguage() {
            return this.canSave && !this.isNew;
        },

        isNew() {
            return !!this.entity.isNew && this.entity.isNew();
        },

        repository() {
            return this.repositoryFactory.create('ovv_entity_template');
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

        isDefaultLanguage() {
            return Shopware.State.getters['context/isSystemDefaultLanguage'];
        },

        cardIdIsVisible() {
            return this.isLoaded && !this.isNew;
        },

        ...mapPropertyErrors('entity', [
            'name',
            'slug',
            'template',
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
            return this.$tc(`ovv.entityTemplate.${value}`);
        },

        aclCan(value) {
            return this.acl.can(`ovv_entity_template.${value}`);
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

        abortOnLanguageChange() {
            return this.repository.hasChanges(this.entity);
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        onChangeLanguage() {
            this.loadEntityData(this.entity.id);
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
                    this.$router.push({ name: 'ovv.entity.template.detail', params: { id: this.entity.id } });
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
            this.$router.push({ name: 'ovv.entity.template.index' });
        },

        pholder(field) {
            return this.placeholder(this.entity, field, this.t('placeholder.' + field));
        },
    },
};
