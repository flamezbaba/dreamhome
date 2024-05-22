<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    page_title: String,
    rows: String | Number,
    records: Object,
    filters: Object,
});

const modals = ref({
    createModal: false,
});

const recordRows = ref(props.rows);

const searchForm = useForm({
    search: props.filters.search,
});

const deleteForm = useForm({
    user_id: "",
    delete_user: true,
});

const banForm = useForm({
    user_id: "",
    ban_user: true,
});

const tableRecords = computed(() => {
    return props.records.data.map((item) => {
        const rr = {};
        rr.data = item;
        rr.actions = [
            {
                type: "action",
                title: "Toggle Ban",
                link: "ban_user",
            },
            {
                type: "action",
                title: "Delete",
                link: "delete_user",
            },
        ];
        return rr;
    });
});

const runSearch = () => {
    searchForm.get(route(route().current()));
};

const cancelSearch = () => {
    searchForm.search = null;
    router.get(route(route().current()));
};

const viaRows = () => {
    router.get(route(route().current()), {
        rows: recordRows.value,
    });
};

const actionClick = (e, payload) => {
    if (e.actionType === "delete_user") {
        deleteForm.user_id = e.data.id;
        payload.openConfirmModal({
            heading: "Are You Sure ?",
            modalWord: "",
            buttonTwoText: "Delete",
            actionTwo: "delete_user",
        });
    }

    if (e.actionType === "ban_user") {
        banForm.user_id = e.data.id;
        payload.openConfirmModal({
            heading: "Are You Sure ?",
            modalWord: "",
            buttonTwoText: "Toggle Ban",
            actionTwo: "ban_user",
        });
    }
};

const confirmModalReturns = (payload) => {
    if (payload === "delete_user") {
        deleteForm.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
        });
    }

    if (payload === "ban_user") {
        banForm.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
        });
    }
};

onMounted(() => {
    // console.log("i need");
});

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
                        <CustomTable
                            :rawRecords="tableRecords"
                            :excludeColumn="['id']"
                            @actionClicked="actionClick($event, contentProps)"
                        >
                            <template #tabletop>
                                <div
                                    class="flex items-center justify-between md:flex-col md:gap-4 p-4 bg-white"
                                >
                                    <SelectRows
                                        v-model="recordRows"
                                        :totalRecords="
                                            $page.props.records.total
                                        "
                                        @onSelect="viaRows"
                                    />
                                    <Search
                                        v-model="searchForm.search"
                                        @onRunSearch="runSearch"
                                        @onCancelSearch="cancelSearch"
                                    />
                                </div>
                            </template>
                            <template #recordsummary>
                                Showing {{ records.from }} to
                                {{ records.to }} of {{ records.total }} records
                            </template>
                            <template #pagination>
                                <Pagination :links="records.links" />
                            </template>
                        </CustomTable>
                    </div>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
</style>
