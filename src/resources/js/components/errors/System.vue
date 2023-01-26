<template>
    <section class="system">
        <h2 class="system_title">システムエラーが発生しました。</h2>
        <p class="system_word">ご不便をおかけして申し訳ありません。</p>
        <p class="system_word">技術的なエラーが発生しております。</p>
        <p class="system_word">復旧までもうしばらくお待ちください。</p>
    </section>
</template>
<script lang="ts">
</script>
<style lang="scss" scoped>
.system {
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
