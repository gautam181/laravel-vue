<template>
    <!-- menu with submenu -->
    <li v-if="menu.children" class="nav-item" v-bind:class="{ 'active': subIsActive(menu.path) }">
        <a href="#" class="nav-link" v-on:click.prevent.stop="expand()">
            <span class="nav-label">{{ menu.title }}</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level" v-bind:class="{ 'd-block': this.isActive == true, 'd-none': this.isActive == false }" v-bind:style="{ marginTop: (options.sidebarMinified) ? - (scrollTop + 40) + 'px' : '' }">
            <template v-for="submenu in menu.children">
                <nav-list v-bind:menu="submenu" v-bind:key="submenu.path" ref="navList" v-on:collapse-other="handleCollapseOther(submenu)"></nav-list>
            </template>
        </ul>
    </li>

    <!-- menu without submenu -->
    <router-link v-else v-bind:to="menu.path" active-class="active" class="nav-item" tag="li" v-on:click.native="collapseOther()">
        <a class="nav-link">
            <span v-if="menu.badge" :class="'badge badge-' + menu.badge.class + ' pull-right'">{{ menu.badge.label }}</span>
            <span class="nav-label">{{ menu.title }}</span>
        </a>
    </router-link>
</template>

<script>
    import Navlist from "./NavList.vue"
    import Settings from "../../config/Settings"

    export default {
        name: "NavList",
        props: ['menu'],
        components: {
          Navlist
        },
        data(){
            return {
                isActive:'',
                options: Settings
            }
        },
        methods: {
            expand: function() {
                if (this.isActive == '') {
                    this.isActive = (this.subIsActive(this.menu.path)) ? false : true;
                } else {
                    this.isActive = (this.stat == 'expand') ? false : true
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
                for (var i = 0; i < this.menu.children.length; i++) {
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