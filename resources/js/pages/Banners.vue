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
import Dropzone, { DropzoneElement } from "../base-components/Dropzone";
import Table from "../base-components/Table";
const deleteButtonRef = ref(null);
const limits = pageLimits();
import Notification from "./Notification.vue";
</script>
<script lang="ts">
import axios from 'axios';
export default {
    data(){
        return {
            banners: [],
            banner:{
                'image' : null
            },
            bannerId: 0,
            deleteConfirmationModal: false,
            bannerModalPreview: false,
            toastText : '',
            toastType : 'success',
            search:''
        }
    },
    mounted() {
        this.getBanners();
        const dropzoneValidationRef = ref<DropzoneElement>();
        const elDropzoneValidationRef = dropzoneValidationRef.value;
        if (elDropzoneValidationRef) {
            elDropzoneValidationRef.dropzone.on("success", () => {
            alert("Added file.");
            });
            elDropzoneValidationRef.dropzone.on("error", () => {
            alert("No more files please!");
            });
        }
    },
    methods : {
        getBanners(url = '/api/banners'){
            axios.get(url).then((response)=>{
                this.banners = response.data.banners;
            }).catch( (error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        setDeleteConfirmationModal(value, id = 0) {
            this.bannerId = id;
            this.deleteConfirmationModal = value;
        },
        setBannerModalPreview(value) {
            this.bannerModalPreview = value;
        },
        saveBanner(){
            axios.post('/api/save-banner', this.banner).then((response) => {
                this.showNoty(response.data.message)
                this.getBanners();
                this.bannerModalPreview = false;
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            })
        },
        deleteBanner() {
            axios.delete('/api/delete-banner/' + this.bannerId).then((response) => {
                console.log(response);
                if (response.status === 'success') {
                    this.showNoty(response.message)
                    this.getBanners("/api/banners");
                    this.deleteConfirmationModal = false;
                }
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        uploadImage(event){
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            };
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append('image',file);
            formData.append('path',"images/banners");
            formData.append('resolution',"|dimensions:min_width=1920,min_height=615,max_width=1920,max_height=915");
            axios.post("/api/upload-image", formData, config).then((response) => {
                if (response.data.status == 'success') {
                    this.banner.image = response.data.filename;
                }
                this.showNoty(response.data.message)
            }).catch( (error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        showNoty(message,type = 'success'){
            this.toastText = message;
            this.toastType = type;
            document.getElementById("toastBtn").click();
        }

    }
}
</script>

<template>
    <Notification :toastText="toastText" :toastType="toastType" />
    <h2 class="mt-10 text-lg font-medium intro-y">Categories</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div
            class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap"
        >
            <Button variant="primary" class="mr-2 shadow-md" 
            @click="
                (event) => {
                    event.preventDefault();
                    setBannerModalPreview(true);
                }
            ">
                Add New Banner
            </Button>
        </div>
        <!-- BEGIN: Data List -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <Table class="border-spacing-y-[10px] border-separate -mt-2">
                <Table.Thead>
                    <Table.Tr>
                        <Table.Th class="border-b-0 whitespace-nowrap"> BANNER </Table.Th>
                        <Table.Th class="text-center border-b-0 whitespace-nowrap">
                            ACTIONS
                        </Table.Th>
                    </Table.Tr>
                </Table.Thead>
                <Table.Tbody>
                    <Table.Tr
                        v-for="(banner, index) in  banners"
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
                                        :src="banner.image !== null ? '/images/banners/'+banner.image : '/images/banners/profile-2.jpg'"
                                    />
                                </div>
                            </div>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-56 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400"
                        >
                            <div class="flex items-center justify-center">
                                <a v-if="$can('banners.remove')"
                                   class="flex items-center text-danger"
                                    href="#"
                                    @click="
                                        (event) => {
                                            event.preventDefault();
                                            setDeleteConfirmationModal(true , banner.id);
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
                <Button  @click="deleteBanner()"
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

    <Dialog :open="bannerModalPreview" @close="
                  () => {
                    seBannerModalPreview(false);
                  }">
    <Dialog.Panel>
        <Dialog.Title>
            <h2 class="mr-auto text-base font-medium">
                ADD BANNER
            </h2>
        </Dialog.Title>
        <Dialog.Description class="grid grid-cols-12 gap-4 gap-y-3">
            <div class="col-span-12">
                <div
                    class="relative flex items-center justify-center px-4 pb-4 mt-5 cursor-pointer"
                >
                    <Lucide icon="Image" class="w-4 h-4 mr-2" />
                    <span class="mr-1 text-primary"> Upload a file </span>
                    or drag and drop
                    <FormInput
                        id="horizontal-form-1"
                        type="file"
                        class="absolute top-0 left-0 w-full h-full opacity-0"
                        @change="uploadImage($event)"
                    />
                </div>
            </div>
        </Dialog.Description>
        <Dialog.Footer>
            <Button type="button" variant="outline-secondary" @click="
                        () => {
                          setBannerModalPreview(false);
                        }
                      " class="w-20 mr-1">
                Cancel
            </Button>
            <Button variant="primary" type="button" class="w-20" ref="" @click="saveBanner()">
                Add
            </Button>
        </Dialog.Footer>
    </Dialog.Panel>
</Dialog>
<!-- END: Modal Content -->
</template>
