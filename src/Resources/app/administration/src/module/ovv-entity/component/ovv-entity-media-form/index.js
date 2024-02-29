import template from './ovv-entity-media-form.html.twig';
import './ovv-entity-media-form.scss';

export default {
    template,

    inject: [ 'repositoryFactory', 'acl' ],

    mixins: [
        'notification',
    ],

    props: {
        entity: {
            type: Object,
            required: true,
        },

        disabled: {
            type: Boolean,
            required: false,
            default: false,
        },

        isLoading: {
            type: Boolean,
            required: false,
            default: false,
        },
    },

    computed: {
        mediaItems() {
            const columnCount = 6;

            const mediaItems = this.entityMedia.slice();
            const placeholderCount = this.getPlaceholderCount(columnCount);

            if (placeholderCount <= 0) {
                return mediaItems;
            }

            for (let i = 0; i < placeholderCount; ++i) {
                mediaItems.push(this.createPlaceholderMedia(mediaItems));
            }

            return mediaItems;
        },

        cover() {
            if (!this.entity) {
                return null;
            }

            const coverId = this.entity.cover ? this.entity.cover.mediaId : this.entity.coverId;

            return this.entity.media.find(media => media.id === coverId);
        },

        entityMediaRepository() {
            return this.repositoryFactory.create('ovv_entity_media');
        },

        entityMedia() {
            return !this.entity ? [] : this.entity.media;
        },
    },

    methods: {
        aclCan(value) {
            return this.acl.can(`ovv_entity_media.${value}`);
        },

        onOpenMedia() {
            this.$emit('media-open');
        },

        getPlaceholderCount(columnCount) {
            if (this.entityMedia.length + 3 < columnCount << 1) {
                columnCount <<= 1;
            }

            let placeholderCount = columnCount;

            if (this.entityMedia.length > 0) {
                placeholderCount = columnCount - (this.entityMedia.length % columnCount);

                if (placeholderCount === columnCount) {
                    return 0;
                }
            }

            return placeholderCount;
        },

        createPlaceholderMedia(mediaItems) {
            return {
                isPlaceholder: true,
                isCover: mediaItems.length <= 0,

                media: {
                    isPlaceholder: true,
                    name: '',
                },

                mediaId: mediaItems.length.toString(),
            };
        },

        successfulUpload({ targetId }) {
            if (this.entity.media.find((entityMedia) => entityMedia.mediaId === targetId)) {
                return;
            }

            const entityMedia = this.createMediaAssociation(targetId);

            this.entity.media.add(entityMedia);
        },

        createMediaAssociation(targetId) {
            const entityMedia = this.entityMediaRepository.create();

            entityMedia.entityId = this.entity.id;
            entityMedia.mediaId = targetId;

            if (this.entity.media.length <= 0) {
                entityMedia.position = 0;

                this.entity.coverId = entityMedia.id;
            } else {
                entityMedia.position = this.entity.media.length;
            }

            return entityMedia;
        },

        onUploadFailed(uploadTask) {
            const toRemove = this.entity.media.find((entityMedia) => entityMedia.mediaId === uploadTask.targetId);

            if (toRemove) {
                if (this.entity.coverId === toRemove.id) {
                    this.entity.coverId = null;
                }

                this.entity.media.remove(toRemove.id);
            }

            this.entity.isLoading = false;
        },

        isCover(entityMedia) {
            if (this.entity.media.length <= 0 || entityMedia.isPlaceholder) {
                return false;
            }

            return entityMedia.id === (this.entity.cover ? this.entity.cover.id : this.entity.coverId);
        },

        removeFile(entityMedia) {
            if (this.entity.coverId === entityMedia.id) {
                this.entity.cover = null;
                this.entity.coverId = null;
            }

            this.entity.media.remove(entityMedia.id);

            if (this.entity.coverId === null && this.entity.media.length > 0) {
                this.entity.cover = this.entity.media.first();
                this.entity.coverId = this.entity.cover.id;

                this.updateMediaItemPositions();
            }
        },

        markMediaAsCover(entityMedia) {
            this.entity.cover = entityMedia;
            this.entity.coverId = entityMedia.id;

            this.entity.media.moveItem(entityMedia.position, 0);

            this.updateMediaItemPositions();
        },

        onMediaItemDragSort(dragData, dropData, validDrop) {
            if (validDrop !== true
                || (dragData.id === this.entity.coverId && dragData.position <= 0)
                || (dropData.id === this.entity.coverId && dropData.position <= 0)) {

                return;
            }

            this.entity.media.moveItem(dragData.position, dropData.position);

            this.updateMediaItemPositions();
        },

        updateMediaItemPositions() {
            this.entityMedia.forEach((medium, index) => {
                medium.position = index;
            });
        },
    },
};
