<template>
    <section class="deleteaccount">
        <h2 class="deleteaccount_title">管理者アカウント削除完了</h2>
        <p class="deleteaccount_word">管理者アカウントが削除されました。</p>
        <p class="deleteaccount_word">ご利用ありがとうございました。</p>
        <p class="deleteaccount_word">またのご利用お待ちしております。</p>
    </section>
</template>
<script lang="ts">
import { defineComponent } from "vue"
export default defineComponent({
    name: 'AdminDeleteAccount',
})

</script>
<style lang="scss" scoped>
.deleteaccount {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    &_title {
        font-size: 70px;
        margin-bottom: 50px;
    }

    &_word {
        font-size: 36px;
    }
}
</style>
