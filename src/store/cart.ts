import { defineStore } from 'pinia'
import axios from "axios"

export const cartCounter = defineStore('cart', {
    //保持したいデータ
    state: () => ({
        items: [] as any[],
    }),
    getters: ({
        totalPrice(state) {
            let total = 0
            for (let i=0; i<state.items.length; i++) {
                total += Number(state.items[i].price)
            }
            return total
        }
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
            return response.data
        },
        async makeOrderDetail(orderDetails:any) {
            const response = await axios.post('api/orderDetail', orderDetails)
            console.log('cart.ts makeOrderDetail response', response)
            // return response.data
        },
        removeItem(item:any) {
            // console.log('cart.ts action removeItem this.items1', this.items);
            // console.log('cart.ts action item', item)
            this.items = this.items.filter(n => n['id'] !== item['id'])
            // console.log('cart.ts action removeItem this.items2', this.items)
        },
        resetItems() {
            this.items = []
            console.log('resetItems')
        }
    },
  })
