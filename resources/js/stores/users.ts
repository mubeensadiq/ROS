import { defineStore } from "pinia";
import axios from 'axios';
import router  from '../router';
export const useUserStore = defineStore("user", {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')),
    }),

    actions: {
        getUser(){
          return JSON.parse(localStorage.getItem('user'));
        },
        async signIn(data) {
            return await axios.post("/api/login", data).then((response) => {
                if(response.data.status === "success"){
                    let authUser = JSON.stringify(response.data.user);
                    this.user = authUser;
                    localStorage.setItem('user', authUser);
                    localStorage.setItem('access_token', response.data.user.api_token);
                    router.push('/admin/products');
                }
                return response.data;
            }).catch( (error) => {
               return error.response.data
            });
        },
        async logout() {
            const res = await axios.post("/api/logout").then((response) => {
                localStorage.removeItem('user');
                router.push('/login');

            }).catch( (error) => {
                console.log(error);
            });
        },
    },
});
