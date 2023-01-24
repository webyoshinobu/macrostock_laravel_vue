import { defineStore } from 'pinia'

type CODE = {
    code: number,
}

// export default {
//     namespaced: true,
// }

export const error = defineStore('error', {
    state: () => ({
        code: null as CODE|null,
    }),
    getters: ({

    }),
    actions: {
        setCode (code:any) {
            this.code = code;
            console.log('error.ts setCode this.code', this.code);
        }
    },
})
