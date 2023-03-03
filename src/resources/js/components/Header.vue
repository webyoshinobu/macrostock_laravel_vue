<template>
  <header class="header">

    <h1 class="header_logo">
        <router-link to="/">
            <img src="../../../public/images/logo_transparent.png" alt="macrostockのロゴ">
        </router-link>
    </h1>

    <nav class="header_nav" :class="{iconActive: iconActive}">
        <div class="header_nav_menu">

            <router-link to="/gallery" class="header_nav_menu_item wd_color_white" :class="{change_header: isChange, iconActive: iconActive}" @click="resetIconActive">Gallery</router-link>

            <!-- <router-link to="/contact" class="header_nav_menu_item wd_color_white" :class="{change_header: isChange}">Contact</router-link> -->

            <router-link v-if="!isLoggedIn" to="/login" class="header_nav_menu_item"><ButtonWhite @click="resetIconActive">Login</ButtonWhite></router-link>
            <p v-else class="header_nav_menu_item" @click="clickLogout"><ButtonWhite @click="resetIconActive">Logout</ButtonWhite></p>

            <router-link v-if="!isLoggedIn" to="/register" class="header_nav_menu_item"><ButtonBlack @click="resetIconActive">Register</ButtonBlack></router-link>
            <router-link to="/admin/mypage" v-else-if="'admin_flag' in userInfo" class="header_nav_menu_item"><ButtonBlack @click="resetIconActive">{{ userInfo.name }} 様 マイページ</ButtonBlack></router-link>
            <router-link to="/mypage" v-else class="header_nav_menu_item"><ButtonBlack @click="resetIconActive">{{ userInfo.name }} 様 マイページ</ButtonBlack></router-link>

        </div>
    </nav>

    <div class="menu_wrap">
        <button :class="{iconActive}" @click="humburgerIcon" class="menu-trigger">
            <span :class="{change_header: isChange}"></span>
            <span :class="{change_header: isChange}"></span>
            <span :class="{change_header: isChange}"></span>
        </button>
    </div>

    <div class="overlay" :class="{iconActive: iconActive}"></div>

  </header>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted, inject } from "vue";
    import { storeToRefs } from "pinia";
    import { auth } from '../../../store/auth';
    import { useRoute, useRouter } from 'vue-router';
    import ButtonWhite from "./common/ButtonWhite.vue";
    import ButtonBlack from "./common/ButtonBlack.vue";
    import { cartCounter } from '../../../store/cart';

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
            const authStore = auth();
            const { userInfo, isLoggedIn, getAdminFlag } = storeToRefs(authStore);
            const token = auth().csrf;
            const iconActive = ref(false)

            // methods
            const humburgerIcon = () => {
                iconActive.value = !iconActive.value
                console.log('Header.vue humburgerIcon() iconActive', iconActive.value)
            };

            const resetIconActive = () => {
                iconActive.value = !iconActive.value
            }

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

            const clickLogout = async () => {
                console.log('Header logout apiStatus', auth().getApiStatus);
                console.log('Header logout admin_flag', auth().getAdminFlag);
                if(auth().getAdminFlag == 1){
                    await authStore.adminLogout();
                }else{
                    await authStore.logout();
                }

                console.log('Header logout apiStatus end', auth().getApiStatus);
                console.log('Header logout admin_flag end', auth().getAdminFlag);

                // ログインページに移動する
                // if (auth().getApiStatus == true) {
                if (auth().getApiStatus == false) {
                    // if (auth().getAdminFlag == 1) {
                    //     router.push({ name: 'admin/login' });
                    // }else{
                    //     router.push({ name: 'login' });
                    // }
                    await cartCounter().resetItems()
                    router.push({ name: 'top' });
                }

                console.log('clickLogout');
            };

            // computed

            // lifecycle hooks
            onMounted(() => { //これがないとページ遷移後のヘッダーのスタイルが変わらない
                addClass();
            });

            return { router, addClass, clickLogout, isChange, userInfo, token, isLoggedIn, onMounted, humburgerIcon, iconActive, resetIconActive };
        },
    });
</script>

<style lang="scss" scoped>
@import "../../sass/_mediaQuery.scss";
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

        @include md {
            // display: none;
            display: block;
            transform: translateX(100vw);
            transition: all .3s linear;
            position: absolute;
            right: 0;
            margin: 0;
            z-index: 99999;
        }

        &_menu {
            display: flex;
            justify-content: space-between;
            list-style-type: none;

            @include md {
                display: block;
                width: 60vw;
                height: 100vh;
                background-color: #ffffff;
                flex-direction: column;
                padding: 50px 0 0 0;
            }

            &_item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-decoration: none;

                @include md {
                    margin: 0 0 30px 0;
                }

                &:first-child {
                    @include md {
                        color: #000000;
                        margin: 0 0 30px 50px;
                    }
                }

                &:not(:first-child) {
                    margin-left: 50px;
                }
            }
        }
    }
    .iconActive{
        @include md {
            // display: block;
            transform: translateX(0);
        }
    }
}

.overlay {
    display: none;

    @include md {
        position: absolute;
        left: 0; top: 0;
        width: 100%; height: 100vh;
        background: rgba(100, 100, 100, .8);
        z-index: 9999;
    }
}
.iconActive{
    @include md {
        display: block;
    }
}

.wd_color_white {
    color: #ffffff;
    font-weight: bold;
}

.change_header {
    color: #000000;
}

//ハンバーガーメニュー
.menu_wrap {
    display: none;

    @include md {
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
// @media screen and (max-width:1024px) {
@include md {
    .menu-trigger {
        display: inline-block;
        transition: all 0.4s;
        box-sizing: border-box;
        position: relative;
        z-index: 99999;
        width: 50px;
        height: 30px;
        background: none;
        border: none;
        appearance: none;
        cursor: pointer;
        margin: 0 27px 0 0;

        span {
            display: inline-block;
            transition: all 0.4s;
            box-sizing: border-box;
            // position: relative;
            z-index: 100;
            position: absolute;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #ffffff;
            border-radius: 4px;

            &:nth-of-type(1) {
                top: 0;
            }

            &:nth-of-type(2) {
                top: 13px;
            }

            &:nth-of-type(3) {
                bottom: 0;
            }
        }
        .change_header {
            background-color: #000000;
        }

    }
    .iconActive {

        span {
            &:nth-of-type(1){
                transform: translateY(13px) rotate(-45deg);
                background-color: #000000;
            }

            &:nth-of-type(2){
                opacity: 0;
            }

            &:nth-of-type(3){
                transform: translateY(-13px) rotate(45deg);
                background-color: #000000;
            }
        }
    }
}
</style>
