<template>
  <section class="gallery">
    <h2 class="gallery_title">Gallery</h2>
    <ul class="gallery_list">
        <li v-for="image in images" :key="image.index" class="gallery_list_item">
            <img :src="image.src" :alt="image.alt" @click="pushImg(image)">
        </li>
    </ul>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import { galleryImgs } from '../../../../store/gallery';

export default defineComponent({
    name: 'Gallery',
    components: {
    },

    setup() {
        //data
        const router = useRouter();
        const images = galleryImgs().product_imgs;
        const selectImg = ref();

        // methods
        const pushImg = (image:any) => {
            selectImg.value = image;
            // router.push( { name:'photo', query: selectImg.value } );
            router.push( { name:'photo', params: selectImg.value } );
            // router.push( { path: '/gallery/photo', params: selectImg.value } );
            // router.push( { name:'photo', params: {index:selectImg.value.index, src:selectImg.value.src, alt:selectImg.value.alt} } );
        };

        onMounted(() => {
            console.log('images', images);
        });

        return { router, images, selectImg, pushImg, onMounted };
    },
});
</script>

<style lang="scss" scoped>
.gallery {
    width: 80%;
    padding: 170px 10% 0 10%;

    &_title {
        font-size: 70px;
        margin-bottom: 20px;
    }

    &_list {
        columns: 3;/*段組みの数*/
        list-style-type: none;

        &_item{
            margin-bottom: 20px;/*各画像下に余白をつける*/

            img {
                width:100%;
                height:auto;
                vertical-align: bottom;/*画像の下にできる余白を削除*/
            }
        }
    }
}

</style>
