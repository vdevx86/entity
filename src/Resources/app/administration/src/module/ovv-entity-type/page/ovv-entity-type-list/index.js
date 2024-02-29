import template from './ovv-entity-type-list.html.twig';
import './ovv-entity-type-list.scss';

const { Criteria } = Shopware.Data;

export default {
    template,

    inject: [ 'repositoryFactory', 'acl' ],

    mixins: [
        'listing',
    ],

    data() {
        return {
            isLoading: true,
            items: null,
            sortBy: 'createdAt',
            sortDirection: 'DESC',
            searchConfigEntity: 'ovv_entity_type',
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

        repository() {
            return this.repositoryFactory.create('ovv_entity_type');
        },

        hasItems() {
            return this.items !== null && this.entitySearchable;
        },

        columns() {
            return [{
                property: 'autoIncrement',
                label: 'ID',
                primary: true,
                width: '100px',
            }, {
                property: 'active',
                label: 'ovv.entityType.active',
                width: '100px',
            }, {
                property: 'slug',
                label: 'ovv.entityType.slug',
                width: '200px',
                allowResize: true,
            }, {
                property: 'name',
                label: 'ovv.entityType.name',
                routerLink: 'ovv.entity.type.detail',
                allowResize: true,
            }, {
                property: 'createdAt',
                label: 'ovv.entityType.createdAt',
                allowResize: true,
                width: '250px',
            }];
        },

        createRoute() {
            return {
                name: 'ovv.entity.type.create',
            };
        },
    },

    methods: {
        t(value) {
            return this.$tc(`ovv.entityType.${value}`);
        },

        aclCan(value) {
            return this.acl.can(`ovv_entity_type.${value}`);
        },

        async getList() {
            this.isLoading = true;
            this.items = null;

            const criteria = await this.addQueryScores(this.term, this.getCriteria());

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            this.repository.search(criteria, this.context).then((searchResult) => {
                this.total = searchResult.total;

                if (searchResult.total > 0) {
                    this.items = searchResult;
                }
            }).finally(() => {
                this.isLoading = false;
            });
        },

        getCriteria() {
            const criteria = new Criteria(this.page, this.limit);

            criteria.setTerm(this.term);
            criteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));

            if (this.sortBy != 'createdAt') {
                criteria.addSorting(Criteria.sort('createdAt', this.sortDirection));
            }

            return criteria;
        },

        updateTotal({ total }) {
            this.total = total;

            if (total <= 0) {
                this.items = null;
            }

            return total;
        },
    },
};
