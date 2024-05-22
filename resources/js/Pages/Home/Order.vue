<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import { useBasicStore } from "@/stores/basic";

const props = defineProps({
    page_title: String,
    order: Array | Object,
    bank: String,
});

const basicStore = useBasicStore();
const modals = ref({ order: false, share: false });
const imgIndex = ref(null);

const form = useForm({
    image: null,
    preview: null,
    upload_receipt: true,
});

function handleSubmit() {
    form.post(window.location.toString(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            form.reset();
        },
    });
}

onMounted(() => {
    // console.log("i need");
});

import Layout from "@/Layouts/Home.vue";
import PlainModal from "@/Components/Modals/Plain.vue";
import SingleDisplay from "@/Components/SingleDisplay.vue";
import {
    mdiFilterCog,
    mdiClose,
    mdiContentCopy,
    mdiMapMarker,
    mdiToilet,
    mdiHeartOutline,
    mdiBedOutline,
    mdiCart,
    mdiShareVariant,
    mdiBathtubOutline,
    mdiFacebook,
    mdiTwitter,
    mdiInstagram,
    mdiWhatsapp,
    mdiHeart,
} from "@mdi/js";
</script>

<template>
    <Layout :title="page_title">
        <template #page-modal="contentProps"> </template>
        <template #page-content="contentProps">
            <div class="w-full">
                <div
                    class="home-card w-full p-[50px] md:p-[10px] flex flex-col items-center justify-center"
                >
                    <p class="text-white text-2xl">Checkout Order</p>
                </div>

                <div class="w-full px-[100px] md:px-[20px] py-[50px]">
                    <div class="bg-neutral-200 px-10 py-5 rounded-lg space-y-3">
                        <div class="">
                            <div v-if="order.is_paid == 0"
                                class="bg-red-600 font-bold text-lg text-white px-4 inline-flex"
                            >
                                Payment Pending
                            </div>

                            <div v-else
                                class="bg-green-600 font-bold text-lg text-white px-4 inline-flex"
                            >
                                Payment Confirmed
                            </div>
                            <p class="text-lg mt-5">#{{ order.uuid }}</p>
                            <p class="text-lg">{{ order.property.title }}</p>
                            <p class="mt-2">
                                <a :href="route('property.view', order.property.uuid)" class="underline">View Property</a>
                            </p>
                            <p class="text-3xl font-bold mt-5">
                                Amount: {{ order?.currency }}
                                {{
                                    Number(
                                        order.amount.toString()
                                    ).toLocaleString()
                                }}
                            </p>
                           
                            <div class="mt-5">
                                <p class="">Make Transfer to</p>
                                <p class="text-lg" v-html="bank"></p>
                            </div>
                        </div>
                        <div class="mt-20" v-if="order.receipt_url">
                            <img :src="order.receipt_url" class="" alt="" />
                        </div>
                        <div class="mt-20">
                            <label for=""></label>
                            <input
                                type="file"
                                class=""
                                @input="(e) => (form.image = e.target.files[0])"
                            />
                        </div>

                        <div class="" v-if="order.is_paid == 0">
                            <button
                                @click="handleSubmit"
                                :class="{
                                    'opacity-25': form.processing,
                                }"
                                :disabled="form.processing"
                                class="bgx-blue rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                            >
                                <p class="">Upload Receipt</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Layout>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
.image {
    float: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    border: 1px solid #ebebeb;
    margin: 5px;
}

.discr {
    &::after {
        content: "";
        width: 12px;
        height: 12px;
        background: var(--h-blue-1);
        position: absolute;
        top: 0;
        left: 20px;
        bottom: -12px;
        clip-path: polygon(50% 100%, 0 25%, 100% 25%);
    }
}

input[type="text"],
select {
    transition: all 0.3s;
    width: 100%;
    border-radius: 10px;
    border: 1px solid #aaa;
    outline: none;
    font-size: 1rem;
    box-shadow: none;

    &:focus {
        box-shadow: none;
        border: 1px solid #eee;
    }
}

input[type="checkbox"] {
    background-color: #fff;
    border: 1px solid #aaa;
    height: 13px;
    margin: 0 11px 0 0;
    position: relative;
    width: 13px;

    /* &:checked {
        box-shadow: none;
        border: none;
    } */
}

.tabx {
    color: #1c1c1e;
    padding: 10px 20px;
    background-color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    font-weight: bold;

    &:first-child {
        border-top-left-radius: 20px;
    }

    &:last-child {
        border-top-right-radius: 20px;
    }

    &:hover {
        color: var(--h-blue-1);
        background-color: rgba(255, 255, 255, 0.9);
    }

    &.active {
        background-color: rgba(255, 255, 255, 0.9);
    }
}

.home-card {
    background: linear-gradient(
            to bottom,
            rgba(28, 28, 30, 0.5),
            rgba(28, 28, 30, 0.9)
        ),
        url("@/assets/img/home1.jpg");
}
</style>
