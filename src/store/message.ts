import { defineStore } from 'pinia'

type CONTENT = {
    content: string,
}

export const message = defineStore('message', {
    state: () => ({
        content: null as CONTENT|null,
    }),
    getters: ({
        getMessage: (state) => state.content ? state.content: null,
    }),
    actions: {
        // setContent (state:any, { content, timeout }:any) {
        setContent (content:any, timeout:any) {
            this.content = content

            if (typeof timeout === 'undefined') {
              timeout = 3000
            }

            setTimeout(() => (content = ''), timeout)

            console.log('message.ts content', this.content, timeout);
        }
    },
})
