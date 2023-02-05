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
                if(response.data.status === "success"){
                    let authUser = JSON.stringify(response.data.user);
                    this.user = authUser;
                    let role = response.data.role;
                    const token = response.data.token;
                    localStorage.setItem('user', authUser);
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('role', role);
                    Permissions = response.data.permissions
                    axios.defaults.headers.common["Authorization"] = "Bearer " + token;
                    if(role === 'Super Admin')
                        router.push('/admin/products');
                    if(role === 'City Manager')
                        router.push('/admin/cities');
                    if(role === 'Branch Manager')
                        router.push('/admin/branches');
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
                localStorage.removeItem('role');
                Permissions = [];

                router.push('/login');

            }).catch( (error) => {
                console.log(error);
            });
        },
    },
});
