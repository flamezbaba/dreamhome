<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    page_title: String,
    settings: Object,
});

const form = useForm({
    edit_bank: true,
    bank_details: props.settings?.value,
});

function handleSubmit(){
    const cn = confirm("Are you sure?");
    if (cn) {
        form.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
        });
    }
}

const confirmModalReturns = (payload) => {};

onMounted(() => {});

import AdminLayout from "@/Layouts/Admin.vue";
import CustomTable from "@/Components/Tables/Custom.vue";
import Pagination from "@/Components/Tables/Pagination.vue";
import SelectRows from "@/Components/Tables/SelectRows.vue";
import Search from "@/Components/Tables/Search.vue";
import DefaultModal from "@/Components/Modals/Default.vue";
import { mdiPlus, mdiClose } from "@mdi/js";
</script>

<template>
    <AdminLayout :title="page_title" @onModalActionTwo="confirmModalReturns">
        <template #page-modal> </template>
        <template #main-content="contentProps">
            <div class="w-full px-[40px] md:px-[20px] md:py-[20px]">
                <div
                    class="page-top w-full flex md:gap-2 md:flex-col items-center md:items-start justify-between md:justify-start mt-5"
                >
                    <div class="title text-[2rem] font-bold capitalize">
                        {{ page_title }}
                    </div>
                </div>
                <div class="page-content w-full flex flex-col items-start">
                    <div class="w-full mt-[10px]">
                        <form @submit.prevent="handleSubmit" class="w-full">
                            <div class="w-full mt-[10px] bg-white">
                                <div
                                    class="flex justify-between items-center w-full bgx-blue text-white py-2 px-4"
                                >
                                    <div class="">
                                        <p class="text-lg font-semibold">
                                            Bank Settings
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="flex flex-col justify-between items-center w-full p-4"
                                >
                                    <div class="w-full flex flex-wrap">
                                        <div class="w-6/12 md:w-full pb-4 pr-8">
                                            <div class="form-group">
                                                <label for="" class="imp"
                                                    >Bank Details
                                                </label>
                                                <textarea v-model="form.bank_details"
                                                    name=""
                                                    class=""
                                                    rows="3"
                                                ></textarea>
                                            </div>
                                        </div>

                                        <div class="w-full mt-2">
                                            <button
                                                class="btn btn-blue"
                                                type="submit"
                                                :class="{
                                                    'opacity-25':
                                                        form.processing,
                                                }"
                                                :disabled="form.processing"
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
</style>
