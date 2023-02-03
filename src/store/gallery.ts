import { defineStore } from 'pinia'
import axios from "axios"

type IMAGES = {
    product_imgs: string[],
}

export const galleryImgs = defineStore('gallery', {
    //保持したいデータ
    state: () =>({
        product_imgs: null as IMAGES|null,
        // //srcのパスは先頭に/がないとPhoto.vueへ遷移後にうまく表示されない
        // product_imgs: {
        //     product_img1: {
        //         index: 1,
        //         src: "/images/product_imgs/dummy_img_horizontal1.jpg",
        //         alt: "サンプル画像"
        //     },
        //     product_img2: {
        //         index: 2,
        //         src: "/images/product_imgs/dummy_img_vertical1.jpg",
        //         alt: "サンプル画像"
        //     },
        //     product_img3: {
        //         index: 3,
        //         src: "/images/product_imgs/dummy_img_horizontal2.jpg",
        //         alt: "サンプル画像"
        //     },
        //     product_img4: {
        //         index: 4,
        //         src: "/images/product_imgs/dummy_img_horizontal2.jpg",
        //         alt: "サンプル画像"
        //     },
        //     product_img5: {
        //         index: 5,
        //         src: "/images/product_imgs/dummy_img_vertical2.jpg",
        //         alt: "サンプル画像"
        //     },
        //     product_img6: {
        //         index: 6,
        //         src: "/images/product_imgs/dummy_img_horizontal3.jpg",
        //         alt: "サンプル画像"
        //     },
        // }
    }),
    getters: ({

    }),
    actions: {
        async getImages () {
            const response = await axios.get('/api/gallery');
            console.log('gallery.ts response.data', response.data);
            const product_ims = response.data || null;
            this.product_imgs = product_ims;
            console.log('gallery.ts this.product_imgs', this.product_imgs);
        },
    },
})
