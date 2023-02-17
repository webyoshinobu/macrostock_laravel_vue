import { defineStore } from 'pinia'
import axios from "axios"

export const cartCounter = defineStore('cart', {
    //保持したいデータ
    state: () => ({
        items: [] as any[],
    }),
    getters: ({

    }),
    actions: {
        addCart(image:any) {
            this.items.push(image);
            // this.items = image;
            console.log('cart.ts action this.items', this.items);
        },
        async makeOrder(downloadItems:any) {
            const response = await axios.post('api/order', downloadItems)
            console.log('cart.ts makeOrder response', response)
        },
        removeItem(item:any) {
            // console.log('cart.ts action removeItem this.items1', this.items);
            // console.log('cart.ts action item', item)
            this.items = this.items.filter(n => n['id'] !== item['id'])
            // console.log('cart.ts action removeItem this.items2', this.items)
        }
    },
  })
