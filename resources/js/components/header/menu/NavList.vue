<template>
    <!-- menu with submenu -->
    <li v-if="menu.children" class="nav-item dropdown" v-bind:class="{ 'active': subIsActive(menu.path) }">
        <a href="#" class="dropdown-toggle"data-toggle="dropdown" >{{ menu.title }}</a>
        <ul  class="dropdown-menu animated flipInX" v-bind:class="{ 'd-block': this.stat == 'expand', 'd-none': this.stat == 'collapse' }">
            <template v-for="submenu in menu.children">
                <nav-list v-bind:menu="submenu" v-bind:key="submenu.path" ref="navList"></nav-list>
            </template>
        </ul>
    </li>

    <!-- menu without submenu -->
    <router-link v-else v-bind:to="menu.path" active-class="active" class="nav-item" tag="li" >
        <a class="">{{ menu.title }}</a>
    </router-link>
</template>

<script>
    import Navlist from "./NavList.vue"
    import Settings from "../../../config/Settings"

    export default {
        name: "NavList",
        props: ['menu'],
        components: {
          Navlist
        },
        data(){
            return {
                stat: '',
                options: Settings
            }
        },
        methods: {
            expand: function() {
                if (this.stat == '') {
                    this.stat = (this.subIsActive(this.menu.path)) ? 'collapse' : 'expand';
                } else {
                    this.stat = (this.stat == 'expand') ? 'collapse' : 'expand'
                }
                this.$emit('collapse-other', this.menu)
            },
            collapse: function(menu) {
                if (this.menu != menu) {
                    this.stat = 'collapse'
                }
            },
            collapseOther: function() {
                this.$emit('collapse-other', this.menu)
            },
            handleCollapseOther: function(menu) {
                for (let i = 0; i < this.menu.children.length; i++) {
                    this.$refs.navList[i].collapse(menu);
                }
            },
            subIsActive(path) {
                const paths = Array.isArray(path) ? path : [path]
                return paths.some(path => {
                    return this.$route.path.indexOf(path) === 0
                })
            }
        }
    }
</script>
