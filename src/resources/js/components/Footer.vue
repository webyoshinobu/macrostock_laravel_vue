<template>
  <footer class="footer">
    <!-- <fa :icon="{ prefix: 'fab', iconName: 'instagram' }" style="color:white;" class="sns_logo fa-5x" /> -->
    <a href="https://instagram.com/macro.stock?igshid=YmMyMTA2M2Y=" target="_blank"><fa :icon="{ prefix: 'fab', iconName: 'instagram' }" class="sns_logo fa-5x" :class="{change_header: isChange}" /></a>
    <router-link v-if="isLoggedIn == false" to="/admin/login" class="footer_admin wd_color_white">
        <p :class="{change_header: isChange}">Administrator Login</p>
    </router-link>
  </footer>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { storeToRefs } from "pinia";
    import { auth } from '../../../store/auth';
    import { useRoute, useRouter } from 'vue-router';
    export default defineComponent({
    name: 'Footer',
    components: {
    },

    setup() {
            // data
            const router = useRouter();
            const route = useRoute();
            const isChange = ref(false);
            const authStore = auth();
            const { isLoggedIn } = storeToRefs(authStore);

            // methods
            const addClass = () => {
                router.afterEach((to) => {
                    const current_path = to.path;
                    if (current_path != '/') {
                        isChange.value = true;
                    }else{
                        isChange.value = false;
                    }
                });
            };

            // computed

            // lifecycle hooks
            onMounted(() => {
                addClass();
                // console.log('Footer.vue isLoggedIn', isLoggedIn);
            });

            return { router, addClass, isChange, isLoggedIn };
        },
    });
</script>

<style lang="scss" scoped>
@import "../../sass/_mediaQuery.scss";
.footer {
    width: 100%;
    position: fixed;
    bottom: 0;
    z-index: 998;
    display: flex;
    justify-content: space-between;

    &_admin {
        display: flex;
        align-items: center;
        margin: 0 27px 20px 0;
        font-size: 24px;
        text-decoration: none;

        @include md {
            display: none;
        }
    }
}

.sns_logo {
    margin: 0 0 20px 27px;
    color: #ffffff;
}

.wd_color_white {
    color: #ffffff;
    font-weight: bold;
}

.change_header {
    color: #000000;
}

</style>
