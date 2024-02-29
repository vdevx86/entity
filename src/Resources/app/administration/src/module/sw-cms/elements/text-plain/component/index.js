import template from './sw-cms-el-text-plain.html.twig';
import './sw-cms-el-text-plain.scss';

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
