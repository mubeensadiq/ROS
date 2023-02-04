import { defineStore } from "pinia";
import axios from 'axios';
import router  from '../router';
export const useUserStore = defineStore("user", {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')),
        token: localStorage.getItem('user') || null,
    }),

    actions: {
        getUser(){
          return JSON.parse(localStorage.getItem('user'));
        },
        async signIn(data) {
            return await axios.post("/api/login", data).then((response) => {
                console.log(response);
                if(response.data.status === "success"){
                    let authUser = JSON.stringify(response.data.user);
                    this.user = authUser;
                    const token = response.data.token;
                    localStorage.setItem('user', authUser);
                    localStorage.setItem('token', response.data.token);
                    axios.defaults.headers.common["Authorization"] = "Bearer " + token;
                    router.push('/admin/products');
                }
                return response.data;
            }).catch( (error) => {
                console.log(error)
               return error.response.data
            });
        },
        async logout() {
            const res = await axios.post("/api/logout").then((response) => {
                localStorage.removeItem('user');
                localStorage.removeItem('token');
                router.push('/login');

            }).catch( (error) => {
                console.log(error);
            });
        },
    },
});
