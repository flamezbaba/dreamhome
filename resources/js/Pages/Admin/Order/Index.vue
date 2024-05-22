<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    page_title: String,
    records: Object,
});

const modals = ref({
    createModal: false,
});

const deleteForm = useForm({
    user_id: "",
    delete_user: true,
});

const toggleForm = useForm({
    order_id: null,
    toggle_paid: true,
});

function togglePaid(r) {
    if (confirm("Are you sure?")) {
        toggleForm.order_id = r.id;
        toggleForm.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toggleForm.reset();
            },
        });
    }
}

const confirmModalReturns = (payload) => {};

onMounted(() => {
    // console.log("i need");
});

import AdminLayout from "@/Layouts/Admin.vue";

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
                    <div class="w-full mt-[10px] overflow-scroll">
                        <table class="plain-table w-full">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Property</th>
                                    <th>Receipt</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(r, n) in records" :key="n">
                                    <td class="space-x-2">
                                        <button
                                            class="cursor-pointer"
                                            @click="togglePaid(r)"
                                        >
                                            Toggle Paid
                                        </button>
                                    </td>
                                    <td>{{ r.uuid }}</td>
                                    <td>{{ r.currency }} {{ Number(r.amount).toLocaleString() }}</td>
                                    <td>
                                        <a
                                            :href="
                                                route(
                                                    'property.view',
                                                    r?.property?.uuid
                                                )
                                            "
                                            target="_blank"
                                            >View Property</a
                                        >
                                    </td>
                                    <td>
                                        <template v-if="r.receipt_url">
                                            <a
                                                :href="r.receipt_url"
                                                target="_blank"
                                                >View Receipt</a
                                            ></template
                                        >
                                    </td>
                                    <td>
                                        {{ r.is_paid == 0 ? "Unpaid" : "Paid" }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
</style>
