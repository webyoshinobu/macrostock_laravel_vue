<template>
  <header class="header">

    <h1 class="header_logo">
        <router-link to="/">
            <img src="../../../public/images/logo_transparent.png" alt="macrostockのロゴ">
        </router-link>
    </h1>

    <nav class="header_nav">
        <ul class="header_nav_menu">
            <router-link to="/gallery" class="header_nav_menu_item wd_color_white" :class="{change_header: isChange}">Gallery</router-link>
            <router-link to="/contact" class="header_nav_menu_item wd_color_white" :class="{change_header: isChange}">Contact</router-link>
            <li class="header_nav_menu_item"><ButtonWhite>Login</ButtonWhite></li>
            <!-- <li class="header_nav_menu_item"><ButtonBlack>Register</ButtonBlack></li> -->
            <router-link to="/register" class="header_nav_menu_item"><ButtonBlack>Register</ButtonBlack></router-link>
        </ul>
    </nav>

  </header>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { useRoute, useRouter } from 'vue-router';
    import ButtonWhite from "./common/ButtonWhite.vue";
    import ButtonBlack from "./common/ButtonBlack.vue";
    export default defineComponent({
        name: 'Header',
        components: {
            ButtonWhite,
            ButtonBlack,
        },

        setup() {
            // data
            const router = useRouter();
            const route = useRoute();
            const isChange = ref(false);

            // methods
            const addClass = () => {
                // console.log('addClass()');
                router.afterEach((to) => {
                    const current_path = to.path;
                    // console.log('現在のページ', current_path);
                    if (current_path != '/') {
                        // console.log('トップじゃない');
                        isChange.value = true;
                    }else{
                        // console.log('トップ');
                        isChange.value = false;
                    }
                });
            };

            // computed

            // lifecycle hooks
            onMounted(() => { //これがないとページ遷移後のヘッダーのスタイルが変わらない
                addClass();
            });

            return { router, addClass, isChange };
        },
    });
</script>

<style lang="scss" scoped>
.header {
    width: 100%;
    display: flex;
    justify-content: space-between;
    position: fixed;
    top: 0;
    z-index: 999;

    &_logo {
        width: 170px;
        margin: 0 0 0 27px;

        a {
            width: 100%;
            height: 100%;

            img {
                width: 100%;
            }
        }
    }


    &_nav{
        height: 170px;
        margin-right: 27px;
        display: flex;
        align-items: center;
        font-size: 24px;

        &_menu {
            display: flex;
            justify-content: space-between;
            list-style-type: none;

            &_item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-decoration: none;

                &:not(:first-child) {
                    margin-left: 50px;
                }
            }
        }
    }
}

.wd_color_white {
    color: #ffffff;
    font-weight: bold;
}

.change_header {
    color: #000000;
}

</style>
