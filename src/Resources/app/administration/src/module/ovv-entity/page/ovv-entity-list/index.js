import template from './ovv-entity-list.html.twig';
import './ovv-entity-list.scss';

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
            searchConfigEntity: 'ovv_entity',
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
            return this.repositoryFactory.create('ovv_entity');
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
                label: 'ovv.entity.active',
                width: '100px',
            }, {
                property: 'type.name',
                label: 'ovv.entity.type',
                width: '200px',
                allowResize: true,
            }, {
                property: 'slug',
                label: 'ovv.entity.slug',
                width: '200px',
                allowResize: true,
            }, {
                property: 'name',
                label: 'ovv.entity.name',
                routerLink: 'ovv.entity.detail',
                allowResize: true,
            }, {
                property: 'createdAt',
                label: 'ovv.entity.createdAt',
                allowResize: true,
                width: '250px',
            }];
        },

        createRoute() {
            return {
                name: 'ovv.entity.create',
            };
        },
    },

    methods: {
        t(value) {
            return this.$tc(`ovv.entity.${value}`);
        },

        aclCan(value) {
            return this.acl.can(`ovv_entity.${value}`);
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

            criteria.addAssociation('type');

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

        typeRoute(item) {
            return {
                name: 'ovv.entity.type.detail',

                params: {
                    id: item.typeId,
                },
            };
        },

        itemHasTypeName(item) {
            return !!item.type?.translated?.name;
        },
    },
};
