<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    page_title: String,
    front_url: String,
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
    record_id: "",
    delete_property: true,
});

const createStaffForm = useForm({
    firstname: null,
    lastname: null,
    email: null,
    job_role: null,
    create_staff: true,
});

const loginForm = useForm({
    user_id: "",
    login_user: true,
    row_index: null,
});

const tableRecords = computed(() => {
    return props.records.data.map((item) => {
        const rr = {};
        rr.data = item;
        rr.actions = [
            {
                type: "link",
                title: "View",
                link: route("admin.property.view", item.uuid),
            },

            {
                type: "action",
                title: "Delete",
                link: "delete",
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

function handleCreate() {
    createStaffForm.post(window.location.toString(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            modals.value.createModal = false;
        },
    });
}

const actionClick = (e, payload) => {
    if (e.actionType === "delete") {
        deleteForm.record_id = e.data.id;
        payload.openConfirmModal({
            heading: "Are You Sure ?",
            modalWord: "",
            buttonTwoText: "Delete",
            actionTwo: "delete",
        });
    }

    if (e.actionType === "login_user") {
        loginForm.user_id = e.data.id;
        loginForm.row_index = e.rowIndex;
        payload.openConfirmModal({
            heading: "Are You Sure ?",
            modalWord: "",
            buttonTwoText: "Login",
            actionTwo: "login_user",
        });
    }
};

const confirmModalReturns = (payload) => {
    if (payload === "delete") {
        deleteForm.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
        });
    }

    // if (payload === "login_user") {
    //     loginForm.post(window.location.toString(), {
    //         preserveScroll: true,
    //         preserveState: true,
    //         onSuccess: () => {
    //             const url = `${props.front_url}/byy-byy/${
    //                 props.users.data[loginForm.row_index]?.login_token
    //             }`;
    //             window.open(url, "_blank");
    //         },
    //     });
    // }
};

onMounted(() => {
    // console.log("i need");
    console.log("m", Math.random())
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
        <template #page-modal>
           
        </template>
        <template #main-content="contentProps">
            <div class="w-full px-[40px] md:px-[20px] md:py-[20px]">
                <div
                    class="page-top w-full flex md:gap-2 md:flex-col items-center md:items-start justify-between md:justify-start mt-5"
                >
                    <div class="title text-[2rem] font-bold capitalize">
                        {{ page_title }}
                    </div>

                    <div class="">
                        <a
                            class="btn btn-blue"
                            :href="route('admin.property.create')"
                        >
                            <svg-icon
                                type="mdi"
                                :size="20"
                                :path="mdiPlus"
                            ></svg-icon>
                            Create Property
                    </a>
                    </div>
                </div>
                <div class="page-content w-full flex flex-col items-start">
                    <div class="w-full mt-[10px]">
                        <CustomTable
                            :rawRecords="tableRecords"
                            :excludeColumn="['id', 'login_token']"
                            @actionClicked="actionClick($event, contentProps)"
                        >
                            <template #tabletop>
                                <div
                                    class="flex items-center justify-between md:flex-col md:gap-4 p-4 bg-white"
                                >
                                    <SelectRows
                                        v-model="recordRows"
                                        :totalRecords="$page.props.records.total"
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
                                Showing {{ records.from }} to {{ records.to }} of
                                {{ records.total }} records
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
