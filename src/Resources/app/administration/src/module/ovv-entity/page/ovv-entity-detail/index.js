import template from './ovv-entity-detail.html.twig';
import './ovv-entity-detail.scss';

const { Criteria } = Shopware.Data;
const { mapPropertyErrors } = Shopware.Component.getComponentHelper();
const { isEmpty } = Shopware.Utils.types;

export default {
    template,

    inject: [ 'acl', 'repositoryFactory', 'customFieldDataProviderService' ],

    mixins: [
        'notification',
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
            customFieldSets: [],
            showMediaModal: false,
            mediaDefaultFolderId: null,
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
            return this.repositoryFactory.create('ovv_entity');
        },

        mediaRepository() {
            return this.repositoryFactory.create(this.entity.media.entity);
        },

        mediaDefaultFolderRepository() {
            return this.repositoryFactory.create('media_default_folder');
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

        customFieldSetCriteria() {
            const criteria = new Criteria(1, null);

            criteria.addFilter(Criteria.equals('relations.entityName', 'ovv_entity'));

            return criteria;
        },

        cardIdIsVisible() {
            return this.isLoaded && !this.isNew;
        },

        cardCustomFieldSetsIsVisible() {
            return this.isLoaded && this.customFieldSets.length > 0;
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
            return this.$tc(`ovv.entity.${value}`);
        },

        aclCan(value) {
            return this.acl.can(`ovv_entity.${value}`);
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

            this.loadCustomFieldSets();

            this.getMediaDefaultFolderId().then((mediaDefaultFolderId) => {
                this.mediaDefaultFolderId = mediaDefaultFolderId;
            });
        },

        loadEntityData(entityId) {
            this.isLoading = true;

            const criteria = new Criteria(1, 1);

            criteria.getAssociation('media')
                .addSorting(Criteria.sort('position', 'ASC'));

            criteria.addAssociation('cover')
                .addAssociation('customFieldSets');

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

            if (this.entity.media) {
                this.entity.media.forEach((medium, index) => {
                    medium.position = index;
                });
            }

            const isNew = this.entity.isNew();

            this.repository.save(this.entity, this.context).then(() => {
                if (isNew) {
                    this.$router.push({ name: 'ovv.entity.detail', params: { id: this.entity.id } });
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
            this.$router.push({ name: 'ovv.entity.index' });
        },

        pholder(field) {
            return this.placeholder(this.entity, field, this.t('placeholder.' + field));
        },

        loadCustomFieldSets() {
            this.customFieldDataProviderService.getCustomFieldSets('ovv_entity').then((sets) => {
                this.customFieldSets = sets;
            });
        },

        getMediaDefaultFolderId() {
            const criteria = new Criteria(1, 1);

            criteria.addAssociation('folder');
            criteria.addFilter(Criteria.equals('entity', 'product'));

            return this.mediaDefaultFolderRepository.search(criteria, this.context.api)
                .then((mediaDefaultFolder) => {
                    const defaultFolder = mediaDefaultFolder.first();

                    if (defaultFolder.folder?.id) {
                        return defaultFolder.folder.id;
                    }

                    return null;
                });
        },

        onOpenMediaModal() {
            this.showMediaModal = true;
        },

        onCloseMediaModal() {
            this.showMediaModal = false;
        },

        onAddMedia(media) {
            if (isEmpty(media)) {
                return;
            }

            media.forEach((item) => {
                this.addMedia(item).catch(({ fileName }) => {
                    this.createNotificationError({
                        message: this.$tc('sw-product.mediaForm.errorMediaItemDuplicated', 0, { fileName }),
                    });
                });
            });
        },

        addMedia(media) {
            if (this.isExistingMedia(media)) {
                return Promise.reject(media);
            }

            const newMedia = this.mediaRepository.create(this.context.api);
            newMedia.mediaId = media.id;
            newMedia.media = {
                url: media.url,
                id: media.id,
            };

            if (isEmpty(this.entity.media)) {
                this.setMediaAsCover(newMedia);
            }

            this.entity.media.add(newMedia);

            return Promise.resolve();
        },

        isExistingMedia(media) {
            return this.entity.media.some(({ id, mediaId }) => {
                return id === media.id || mediaId === media.id;
            });
        },

        setMediaAsCover(media) {
            media.position = 0;

            this.entity.coverId = media.id;
        },
    },
};
