import { defineStore } from "pinia";
import axios from 'axios';
import router  from '../router';
export const useUserStore = defineStore("user", {
    state: () => ({
        user: localStorage.getItem('user'),
    }),

    actions: {
        async signIn(data) {
            const res = await axios.post("/api/login", data).then((response) => {
                const user = response.data.user;
                this.user = user;
                localStorage.setItem('user', user);
                router.push('/');

            }).catch( (error) => {
               console.log(error);
            });
        },
    },
});
