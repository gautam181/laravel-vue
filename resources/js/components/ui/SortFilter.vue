<template>
    <div class="sort-filter">
        <b-dropdown variant="default" right size="sm">
            <template slot="button-content">
                <strong>Sort By: </strong> {{selected_option}}
            </template>
            <template v-for="option in options">
                <b-dropdown-item-button :data-id="option.id" :active="option.id == selected" @click="updateSort(option.id)">{{ option.label }}</b-dropdown-item-button>
            </template>
        </b-dropdown>
        <button class="btn btn-default btn-sm" @click="updateOrder"><i :class="'fa '+sort_icon "></i></button>
    </div>
</template>

<script>
    export default {
        name: "SortFilter",
        props: {
            options:{type: Array, required: true, default: {}},
            order: {type: String, default: 'asc'},
            selected: {type: String}
        },
        methods: {},
        data() {
            return {
               // sort_icon: this.order == 'asc' ? 'fa-arrow-up' : 'fa-arrow-up'
            }
        },
        mounted() {
        },
        computed: {
            sort_icon: function () {
                return this.order == 'asc' ? 'fa-arrow-up' : 'fa-arrow-down';
            },
            selected_option: function () {
                let sopt = this.options.find(option => this.selected === option.id);
                return sopt? sopt.label : this.options[0].label;
            }
        },
        watch: {},
        methods: {
            updateOrder: function () {
                let sorder = this.order == 'asc' ? 'desc' : 'asc';
                this.$emit('update-order', sorder);
            },
            updateSort: function (val) {
                this.$emit('update-sort', val);
            }
        }
    }
</script>

<style scoped>

</style>
