import template from './sw-cms-el-config-text-plain.html.twig';
import './sw-cms-el-config-text-plain.scss';

const { Mixin } = Shopware;

export default {
    template,

    mixins: [
        Mixin.getByName('cms-element'),
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('text-plain');
        },
    },
};
