<template>
  <footer class="footer">
    <!-- <fa :icon="{ prefix: 'fab', iconName: 'instagram' }" style="color:white;" class="sns_logo fa-5x" /> -->
    <fa :icon="{ prefix: 'fab', iconName: 'instagram' }" class="sns_logo fa-5x" :class="{change_header: isChange}" />
    <p class="footer_admin wd_color_white" :class="{change_header: isChange}">Administrator Login</p>
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
}

.sns_logo {
    margin: 0 0 20px 27px;
    color: #ffffff;
}

.footer_admin {
    display: flex;
    align-items: center;
    margin: 0 27px 20px 0;
    font-size: 24px;
}

//共通
.bg-white {
    background-color: #ffffff;
    color: #000000;
    font-weight: bold;
}

.bg-black {
    background-color: #000000;
    color: #ffffff;
    font-weight: bold;
}

.wd_color_white {
    color: #ffffff;
    font-weight: bold;
}

.change_header {
    color: #000000;
}

</style>
