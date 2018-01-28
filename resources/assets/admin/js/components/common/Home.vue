<template>
    <div class="wrapper">
        <v-head></v-head>
        <section>
            <v-sidebar @sidebarCollapse="isCollapseFunc"></v-sidebar>
            <div class="content" v-bind:class="{'is-collapse':isCollapse,'not-collapse':!isCollapse}">
                <transition name="move" mode="out-in">
                    <router-view></router-view>
                </transition>
            </div>
        </section>

    </div>
</template>

<script>
    import vHead from './Header.vue';
    import vSidebar from './Sidebar.vue';

    export default {
        data() {
            return {
                isCollapse: false
            }
        },
        components: {
            vHead, vSidebar
        },
        methods: {
            isCollapseFunc (param) {
                return this.isCollapse=param
            }
        }
    }
</script>
<style>
    .section {
        width: 100%;
    }

    .content {
        background: none repeat scroll 0 0 #fff;
        position: absolute;
        left: 200px;
        right: 0;
        top: 60px;
        bottom: 0;
        width: auto;
        padding: 40px;
        box-sizing: border-box;
        overflow-y: scroll;
    }

    .is-collapse {
        left: 64px;
        transition:left .3s;
        -moz-transition:left .3s; /* Firefox 4 */
        -webkit-transition:left .3s; /* Safari and Chrome */
        -o-transition:left .3s; /* Opera */
    }

    .not-collapse {
        left: 200px;
        transition:left .6s;
        -moz-transition:left .6s; /* Firefox 4 */
        -webkit-transition:left .6s; /* Safari and Chrome */
        -o-transition:left .6s; /* Opera */
    }

    .crumbs {
        margin-bottom: 20px;
    }
</style>

