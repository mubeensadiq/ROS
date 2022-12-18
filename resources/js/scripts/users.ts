import { defineComponent } from "vue";
import _ from "lodash";
import dayjs from "dayjs";

interface Users {
    name: string;
    email: string;
}
import axios from 'axios';
const fakerData: Array<{
    users : []
}> = [];
const usersList = {
    getUsers() {
        const Users = [];
        axios.get('/api/users').then((response)=>{
            const\\\ Users = response.data.users;
        }).catch( (error) => {
            console.log(error);
        });
        return Users;
    }
};

export default usersList;


