<template>
  <footer class="footer">
    <!-- <fa :icon="{ prefix: 'fab', iconName: 'instagram' }" style="color:white;" class="sns_logo fa-5x" /> -->
    <fa :icon="{ prefix: 'fab', iconName: 'instagram' }" class="sns_logo fa-5x" :class="{change_header: isChange}" />
    <router-link to="/admin/login" class="footer_admin wd_color_white">
        <p :class="{change_header: isChange}">Administrator Login</p>
    </router-link>
  </footer>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
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
            });

            return { router, addClass, isChange };
        },
    });
</script>

<style lang="scss" scoped>
.footer {
    width: 100%;
    position: fixed;
    bottom: 0;
    z-index: 999;
    display: flex;
    justify-content: space-between;

    &_admin {
        display: flex;
        align-items: center;
        margin: 0 27px 20px 0;
        font-size: 24px;
        text-decoration: none;
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
