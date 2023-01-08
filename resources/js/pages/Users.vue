<script setup lang="ts">
import _ from "lodash";
import { ref } from "vue";
import Button from "../base-components/Button";
import {pageLimits} from "../utils/helper";
import Pagination from "../base-components/Pagination";
import { FormInput, FormSelect } from "../base-components/Form";
import Lucide from "../base-components/Lucide";
import Tippy from "../base-components/Tippy";
import { Dialog, Menu } from "../base-components/Headless";
import Table from "../base-components/Table";
const deleteButtonRef = ref(null);
const limits = pageLimits();
</script>
<script lang="ts">
import axios from 'axios';
export default {
    data(){
        return {
            users: [],
            userID: 0,
            deleteConfirmationModal: false
        }
    },
    mounted() {
        this.getUsers();

    },
    methods : {
        getUsers(url = '/api/users'){
            axios.get(url).then((response)=>{
                this.users = response.data.users;
            }).catch( (error) => {
                console.log(error);
            });
        },
        setDeleteConfirmationModal(value, id = 0) {
            this.userID = id;
            this.deleteConfirmationModal = value;
        },
        deleteUser() {
            axios.delete('/api/delete-user/' + this.userID).then((response) => {
                if (response.data.status === 'success') {
                    this.getUsers("/api/users?page=" + this.users.current_page);
                    this.deleteConfirmationModal = false;
                }
            }).catch((error) => {

            });
        }

    }
}
</script>

<template>
  <h2 class="mt-10 text-lg font-medium intro-y">Users</h2>
  <div class="grid grid-cols-12 gap-6 mt-5">
    <div
      class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap"
    >
        <RouterLink :to="{name : 'createUser' }">
          <Button variant="primary" class="mr-2 shadow-md">
            Add New User
          </Button>
        </RouterLink>
      <Menu>
        <Menu.Button :as="Button" class="px-2 !box">
          <span class="flex items-center justify-center w-5 h-5">
            <Lucide icon="Plus" class="w-4 h-4" />
          </span>
        </Menu.Button>
        <Menu.Items class="w-40">
          <Menu.Item>
            <Lucide icon="Printer" class="w-4 h-4 mr-2" /> Print
          </Menu.Item>
          <Menu.Item>
            <Lucide icon="FileText" class="w-4 h-4 mr-2" /> Export to Excel
          </Menu.Item>
          <Menu.Item>
            <Lucide icon="FileText" class="w-4 h-4 mr-2" /> Export to PDF
          </Menu.Item>
        </Menu.Items>
      </Menu>
      <div class="hidden mx-auto md:block text-slate-500">
        Showing {{users.from}} to {{ users.to }} of {{ users.total }} entries
      </div>
      <div class="w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0">
        <div class="relative w-56 text-slate-500">
          <FormInput
            type="text"
            class="w-56 pr-10 !box"
            placeholder="Search..."
          />
          <Lucide
            icon="Search"
            class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3"
          />
        </div>
      </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
      <Table class="border-spacing-y-[10px] border-separate -mt-2">
        <Table.Thead>
          <Table.Tr>
            <Table.Th class="border-b-0 whitespace-nowrap"> IMAGE </Table.Th>
            <Table.Th class="border-b-0 whitespace-nowrap">
               NAME
            </Table.Th>
            <Table.Th class="border-b-0 whitespace-nowrap"> Email </Table.Th>
            <Table.Th class="border-b-0 whitespace-nowrap"> Phone Number </Table.Th>
            <Table.Th class="text-center border-b-0 whitespace-nowrap">
              STATUS
            </Table.Th>
            <Table.Th class="text-center border-b-0 whitespace-nowrap">
              ACTIONS
            </Table.Th>
          </Table.Tr>
        </Table.Thead>
        <Table.Tbody>
          <Table.Tr
            v-for="(user, index) in  users.data"
            :key="index"
            class="intro-x"
          >
            <Table.Td
              class="first:rounded-l-md last:rounded-r-md w-40 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
            >
              <div class="flex">
                <div class="w-10 h-10 image-fit zoom-in">
                  <Tippy
                    as="img"
                    alt="User Profile Image"
                    class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                    :src="user.profile && user.profile.avatar !== null ? '/images/avatar/'+user.profile.avatar : '/images/avatar/profile-2.jpg'"
                    content=""
                  />
                </div>
              </div>
            </Table.Td>
            <Table.Td
              class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
            >
              <a href="" class="font-medium whitespace-nowrap">
                {{ user.full_name }}
              </a>
            </Table.Td>
              <Table.Td
                  class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
              >
                  <a href="" class="font-medium whitespace-nowrap">
                      {{user.email}}
                  </a>
              </Table.Td>
              <Table.Td
                  class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
              >
                  <a href="" class="font-medium whitespace-nowrap">
                      {{user.profile ? user.profile.phone_number : 'N/A'}}
                  </a>
              </Table.Td>
            <Table.Td
              class="first:rounded-l-md last:rounded-r-md w-40 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
            >
              <div
                :class="[
                  'flex items-center justify-center',
                  { 'text-success': user.status === 1 },
                  { 'text-danger': user.status === 0 },
                ]"
              >
                <Lucide icon="CheckSquare" class="w-4 h-4 mr-2" />
                {{ user.status === 1 ? "Active" : "Inactive" }}
              </div>
            </Table.Td>
            <Table.Td
              class="first:rounded-l-md last:rounded-r-md w-56 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400"
            >
              <div class="flex items-center justify-center">
                  <RouterLink :to="{name : 'updateUser', params:{'id' : user.id} }"
                              class="flex items-center mr-3">
                      <Lucide icon="CheckSquare" class="w-4 h-4 mr-1"/>
                      Edit
                  </RouterLink>
                  <a
                      class="flex items-center text-danger"
                      href="#"
                      @click="
                                        (event) => {
                                            event.preventDefault();
                                            setDeleteConfirmationModal(true , category.id);
                                        }
                                    "
                  >
                      <Lucide icon="Trash2" class="w-4 h-4 mr-1"/>
                      Delete
                  </a>
              </div>
            </Table.Td>
          </Table.Tr>
        </Table.Tbody>
      </Table>
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <div
      class="flex flex-wrap items-center col-span-12 intro-y sm:flex-row sm:flex-nowrap"
    >
      <Pagination class="w-full sm:w-auto sm:mr-auto">
        <Pagination.Link @click="getUsers(users.first_page_url)">
          <Lucide icon="ChevronsLeft" class="w-4 h-4" />
        </Pagination.Link>
        <Pagination.Link v-if="users.prev_page_url" @click="getUsers(users.prev_page_url)">
          <Lucide icon="ChevronLeft" class="w-4 h-4" />
        </Pagination.Link>
        <Pagination.Link v-if="users.current_page - 1 > 1">...</Pagination.Link>
        <Pagination.Link  v-if="users.prev_page_url" @click="getUsers(users.prev_page_url)">{{users.current_page - 1}}</Pagination.Link>
        <Pagination.Link active>{{users.current_page}}</Pagination.Link>
          <Pagination.Link  v-if="users.next_page_url" @click="getUsers(users.next_page_url)">{{users.current_page + 1}}</Pagination.Link>
        <Pagination.Link v-if="users.last_page - users.current_page > 1">...</Pagination.Link>
        <Pagination.Link v-if="users.next_page_url" @click="getUsers(users.next_page_url)">
          <Lucide icon="ChevronRight" class="w-4 h-4" />
        </Pagination.Link>
        <Pagination.Link @click="getUsers(users.last_page_url)">
          <Lucide icon="ChevronsRight" class="w-4 h-4" />
        </Pagination.Link>
      </Pagination>
        <label>Page Size</label>
      <select class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 w-20 mt-3 !box sm:mt-0" v-model="users.per_page">
        <option v-for="page in limits" :value="page">{{page}}</option>
      </select>
    </div>
    <!-- END: Pagination -->
  </div>
  <!-- BEGIN: Delete Confirmation Modal -->
  <Dialog
    :open="deleteConfirmationModal"
    @close="
      () => {
        setDeleteConfirmationModal(false);
      }
    "
    :initialFocus="deleteButtonRef"
  >
    <Dialog.Panel>
      <div class="p-5 text-center">
        <Lucide icon="XCircle" class="w-16 h-16 mx-auto mt-3 text-danger" />
        <div class="mt-5 text-3xl">Are you sure?</div>
        <div class="mt-2 text-slate-500">
          Do you really want to delete these records? <br />
          This process cannot be undone.
        </div>
      </div>
      <div class="px-5 pb-8 text-center">
        <Button
          variant="outline-secondary"
          type="button"
          @click="
            () => {
              setDeleteConfirmationModal(false);
            }
          "
          class="w-24 mr-1"
        >
          Cancel
        </Button>
        <Button  @click="deleteUser()"
          variant="danger"
          type="button"
          class="w-24"
          ref="deleteButtonRef"
        >
          Delete
        </Button>
      </div>
    </Dialog.Panel>
  </Dialog>
  <!-- END: Delete Confirmation Modal -->
</template>
