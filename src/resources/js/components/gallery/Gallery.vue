<template>
  <section class="gallery">
    <h2 class="gallery_title">Gallery</h2>
    <ul class="gallery_list">
        <li v-for="image in images" :key="image.index" :ref="images" class="gallery_list_item">
            <!-- <img :src="image.src" :alt="image.alt" @click="pushImg(image)"> -->
            <img :src="image.url" :alt="image.owner" @click="pushImg(image)">
        </li>
    </ul>
    <Pagination :current-page="currentPage" :last-page="lastPage" />
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, reactive } from "vue";
import { useRoute, useRouter } from 'vue-router';
import { storeToRefs } from 'pinia';
// import { galleryImgs } from '../../../../store/gallery';
import axios from "axios"
import { OK } from '../../util'
import { error } from "../../../../store/error";
import Pagination from '../Pagination.vue'

export default defineComponent({
    name: 'Gallery',
    components: {
        Pagination,
    },

    props: {
        page: {
            type: Number,
            required: false,
            default: 1
        },
        route: {
            type: String,
        }
    },

    setup(props) {
        //data
        const router = useRouter()
        // const { product_imgs } = storeToRefs(galleryImgs());
        // let images:any=[];
        let images = ref({})
        let currentPage = ref(0)
        let lastPage = ref(0)
        const selectImg = ref()

        // methods
        const pushImg = (image:any) => {
            selectImg.value = image;
            // router.push( { name:'photo', query: selectImg.value } );
            router.push( { name:'photo', params: selectImg.value } );
            // router.push( { path: '/gallery/photo', params: selectImg.value } );
            // router.push( { name:'photo', params: {index:selectImg.value.index, src:selectImg.value.src, alt:selectImg.value.alt} } );
        };

        const galleryList = async () => {
            // const response = await axios.get('/api/gallery');
            const response = await axios.get('/api/gallery/?page=${props.page}');

            if (response.status !== OK) {
                error().setCode(response.status);
                return false
            }

            console.log('Gallery.vue response', response.data);
            // images.value = response.data.data;
            // console.log('Gallery.vue images', images.value)
            images.value = response.data.data
            console.log('Gallery.vue images', images.value)
            currentPage.value = response.data.current_page
            console.log('Gallery.vue currentPage', currentPage.value)
            lastPage.value = response.data.last_page
            console.log('Gallery.vue lastPage', lastPage.value)
        }

        onMounted(() => {

        });

        return { router, selectImg, pushImg, galleryList, images, currentPage, lastPage };
    },

    watch: {
        route: {
            async handler () {
                await this.galleryList()
            },
            immediate: true
        }
    }
});
</script>

<style lang="scss" scoped>
.gallery {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

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
