<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import { useBasicStore } from "@/stores/basic";

const props = defineProps({
    page_title: String,
    property: Array | Object,
    others: Array | Object,
});

const basicStore = useBasicStore();
const modals = ref({ order: false, share: false });
const imgIndex = ref(null);
const pageUrl = ref(window.location.toString());

const orderForm = useForm({
    place_order: true,
    property_id: props.property.id,
});

function reserve(d) {
    if (d.isAuth) {
        orderForm.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
        });
    } else {
        modals.value.order = false;
        d.doLogin();
    }
}

async function copyURL() {
    await navigator.clipboard.writeText(pageUrl.value);
}

const images = computed(() => {
    return props.property.images.map((i) => {
        return i;
    });
});

const showVid = ref(false);

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
    mdiArrowDown,
    mdiArrowUp,
} from "@mdi/js";
</script>

<template>
    <Layout :title="page_title">
        <template #page-modal="contentProps">
            <PlainModal :show="modals.order">
                <template #modal-content>
                    <div class="w-[37%] md:w-[84%] bg-white rounded-none">
                        <div
                            class="w-full flex justify-between items-center px-[20px] py-[10px] border-b-2"
                        >
                            <p class="text-lg">Place Order</p>
                            <svg-icon
                                @click="modals.order = false"
                                type="mdi"
                                :size="20"
                                :path="mdiClose"
                                class="cursor-pointer"
                            ></svg-icon>
                        </div>
                        <div class="w-full mt-[20px] md:mt-[5px]">
                            <div class="mt-[20px] px-[20px] w-full">
                                <p class="">{{ property?.title }}</p>
                                <p class="">ID: {{ property?.uuid }}</p>

                                <div class="text-blue-1 text-center mt-5">
                                    <p
                                        class="capitalize break-words font-bold text-xl leading-none"
                                    >
                                        {{ property?.currency?.symbol }}
                                        {{
                                            Number(
                                                property.price
                                            ).toLocaleString()
                                        }}
                                      
                                    </p>
                                    <p
                                        class="text-lg leading-none font-normal lowercase"
                                    >
                                        {{ property.price_suffix }}
                                        <br>
                                        <br>
                                        <span class="" v-if="property.bonus > 0">{{ property.bonus }}% Bonus</span>
                                    </p>

                                </div>
                            </div>

                            <div class="w-full flex mt-10">
                                <div
                                    @click="modals.order = false"
                                    class="w-1/2 bg-red-500 hover:bg-red-600 text-white text-center duration-300 p-5 md:p-3 md:py-5 font-semibold cursor-pointer"
                                >
                                    Cancel
                                </div>
                                <div
                                    @click="reserve(contentProps)"
                                    class="w-1/2 text-center bgx-blue text-white duration-300 p-5 md:p-3 md:py-5 font-semibold cursor-pointer"
                                >
                                    Make Payment
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </PlainModal>

            <PlainModal :show="modals.share">
                <template #modal-content>
                    <div class="w-[37%] md:w-[84%] bg-white rounded-none">
                        <div
                            class="w-full bg-blue-500 text-white flex justify-between items-center px-[20px] py-[10px] border-b-2"
                        >
                            <p class="text-lg">Share Property</p>
                            <svg-icon
                                @click="modals.share = false"
                                type="mdi"
                                :size="20"
                                :path="mdiClose"
                                class="cursor-pointer"
                            ></svg-icon>
                        </div>
                        <div
                            class="w-full mt-[10px] mb-[30px] px-[20px] md:mt-[5px]"
                        >
                            <p class="text-lg">
                                Share this property with friends via
                            </p>
                            <div
                                class="w-full flex flex-wrap items-center gap-6"
                            >
                                <a
                                    target="_blank"
                                    :href="`whatsapp://send?text=${encodeURIComponent(
                                        pageUrl
                                    )}`"
                                >
                                    <svg-icon
                                        type="mdi"
                                        :size="48"
                                        :path="mdiWhatsapp"
                                        class="cursor-pointer text-blue-600"
                                    ></svg-icon>
                                </a>

                                <a
                                    target="_blank"
                                    :href="`https://facebook.com/share.php?u=${encodeURIComponent(
                                        pageUrl
                                    )}`"
                                >
                                    <svg-icon
                                        type="mdi"
                                        :size="48"
                                        :path="mdiFacebook"
                                        class="cursor-pointer text-blue-600"
                                    ></svg-icon>
                                </a>

                                <a
                                    target="_blank"
                                    :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(
                                        pageUrl
                                    )}`"
                                >
                                    <svg-icon
                                        type="mdi"
                                        :size="48"
                                        :path="mdiTwitter"
                                        class="cursor-pointer text-sky-500"
                                    ></svg-icon>
                                </a>

                                <a target="_blank" href="https://instagram.com">
                                    <svg-icon
                                        type="mdi"
                                        :size="48"
                                        :path="mdiInstagram"
                                        class="cursor-pointer text-pink-600"
                                    ></svg-icon>
                                </a>
                            </div>
                            <div class="w-full mt-6">
                                <p class="text-blue-500 font-semibold">
                                    Copy Link
                                </p>
                                <div
                                    @click="copyURL"
                                    class="w-full break-all cursor-pointer flex items-center gap-4 mt-2 ring-2 ring-blue-500 text-blue-500 rounded-md px-4 py-3 md:py-1"
                                >
                                    <svg-icon
                                        type="mdi"
                                        :size="20"
                                        :path="mdiContentCopy"
                                        class="cursor-pointer flex-shrink-0"
                                    ></svg-icon>
                                    <span
                                        class="break-all font-bold cursor-copy text-lg"
                                    >
                                        {{ pageUrl }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </PlainModal>
        </template>
        <template #page-content="contentProps">
            <div class="w-full">
                <div
                    class="w-full flex md:flex-col gap-6 px-[50px] pt-[20px] pb-[50px] md:px-[20px] bg-gray-500"
                >
                    <div class="w-[70%] md:w-full">
                        <div
                            class="w-full mb-5 bg-gray-100 py-3 px-5 md:px-2 shadow-sm rounded-sm"
                        >
                            <div
                                class="w-full flex md:flex-col md:gap-4 justify-between md:justify-end"
                            >
                                <div class="">
                                    <p
                                        class="text-2xl leading-none font-semibold"
                                    >
                                        {{ property?.title }}
                                    </p>
                                    <div
                                        v-if="property.address"
                                        class="flex gap-1 items-center text-[var(--bt-2)] mt-1"
                                    >
                                        <span class="mt-[2px]">
                                            <svg-icon
                                                type="mdi"
                                                :size="16"
                                                :path="mdiMapMarker"
                                            ></svg-icon>
                                        </span>
                                        <p class="break-words bt2 capitalize">
                                            {{ property.address }}
                                        </p>
                                    </div>
                                </div>

                                <div class="text-blue-1 md:hidden">
                                    <p
                                        class="capitalize break-words font-bold text-xl leading-none"
                                    >
                                        {{ property?.currency?.symbol }}
                                        {{
                                            Number(
                                                property.price
                                            ).toLocaleString()
                                        }}
                                    </p>
                                    <p
                                        class="text-lg leading-none font-normal lowercase"
                                    >
                                        {{ property.price_suffix }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mb-5">
                            <v-gallery
                                :images="images"
                                :index="imgIndex"
                                @close="imgIndex = null"
                            />

                            <div class="w-full">
                                <div class="w-full h-[400px]">
                                    <img
                                        @click="imgIndex = 0"
                                        :src="images[0]"
                                        alt=""
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="w-full flex justify-between mb-5 bg-white py-3 px-5 shadow-sm rounded-sm"
                        >
                            <div
                                class="md:hidden bt2 w-6/12 flex justify-between items-start mt-2"
                            >
                                <div
                                    v-if="property.bedrooms"
                                    class="flex gap-1 items-center mt-1"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiBedOutline"
                                        ></svg-icon>
                                    </span>
                                    <p class="">{{ property.bedrooms }} Beds</p>
                                </div>

                                <div
                                    v-if="property.bathrooms"
                                    class="flex gap-1 items-center mt-1"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiBathtubOutline"
                                        ></svg-icon>
                                    </span>
                                    <p class="">
                                        {{ property.bathrooms }} Baths
                                    </p>
                                </div>

                                <div
                                    v-if="property.toilets"
                                    class="flex gap-1 items-center mt-1"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiToilet"
                                        ></svg-icon>
                                    </span>
                                    <p class="">
                                        {{ property.toilets }} Toilets
                                    </p>
                                </div>
                            </div>

                            <div class="text-blue-1 md:visible lg:hidden">
                                <p
                                    class="capitalize break-words font-bold text-xl leading-none"
                                >
                                    ₦
                                    {{
                                        Number(property.price).toLocaleString()
                                    }}
                                </p>
                                <p
                                    class="text-lg leading-none font-normal lowercase"
                                >
                                    {{ property.price_suffix }}
                                </p>
                            </div>

                            <div class="">
                                <button
                                    @click="modals.order = true"
                                    class="bgx-blue cursor-pointer rounded-sm px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiCart"
                                        ></svg-icon>
                                    </span>
                                    <p class="md:hidden lg:visible">Reserve</p>
                                </button>
                            </div>
                        </div>

                        <div
                            class="w-full flex justify-between mb-5 bg-white py-3 px-5 shadow-sm rounded-sm"
                        >
                            <div
                                class="lg:hidden bt2 flex gap-5 items-center mt-2"
                            >
                                <div
                                    v-if="property.bedrooms"
                                    class="flex gap-1 items-center mt-1"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiBedOutline"
                                        ></svg-icon>
                                    </span>
                                    <p class="">{{ property.bedrooms }}</p>
                                </div>

                                <div
                                    v-if="property.bathrooms"
                                    class="flex gap-1 items-center mt-1"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiBathtubOutline"
                                        ></svg-icon>
                                    </span>
                                    <p class="">
                                        {{ property.bathrooms }}
                                    </p>
                                </div>

                                <div
                                    v-if="property.toilets"
                                    class="flex gap-1 items-center mt-1"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiToilet"
                                        ></svg-icon>
                                    </span>
                                    <p class="">
                                        {{ property.toilets }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-5 items-center">
                                <svg-icon
                                    @click="basicStore.toggleFav(property.uuid)"
                                    :class="[
                                        basicStore.isFav(property.uuid)
                                            ? 'text-red-500 hover:text-gray-100'
                                            : 'text-gray-100 hover:text-red-500',
                                    ]"
                                    type="mdi"
                                    :size="30"
                                    :path="mdiHeart"
                                    class="cursor-pointer duration-500"
                                ></svg-icon>

                                <svg-icon
                                    @click="modals.share = true"
                                    type="mdi"
                                    :size="30"
                                    :path="mdiShareVariant"
                                    class="cursor-pointer"
                                ></svg-icon>
                            </div>
                        </div>

                        <div
                            class="w-full mb-5 bg-white py-3 px-5 shadow-sm rounded-sm"
                        >
                           <div class="w-full flex pb-4 justify-between items-center" @click="showVid = !showVid">
                                <p class="text-xl">Videos</p>
                                <div>
                                    <svg-icon v-if="showVid"
                                            type="mdi"
                                            :size="19"
                                            :path="mdiArrowUp"
                                    ></svg-icon>
                                    <svg-icon v-else
                                            type="mdi"
                                            :size="19"
                                            :path="mdiArrowDown"
                                    ></svg-icon>
                                </div>
                           </div>
                            <div class="flex flex-wrap gap-5 w-full items-center" v-show="showVid">
                                <video :src="r" class="w-[350px]" alt="" v-for="(r, n) in property.vids" :key="n" controls="play,volume"></video>
                            </div>
                        </div>

                        <div
                            class="w-full mb-5 bg-white py-3 px-5 shadow-sm rounded-sm"
                        >
                            <div class="">
                                <p class="font-bold text-xl">Details</p>
                                <div
                                    class="w-full grid grid-cols-5 md:grid-cols-2 gap-4 mt-6"
                                >
                                    <div class="">
                                        <p class="font-[500] text-sm">
                                            Property ID
                                        </p>
                                        <p class="text-lg capitalize">
                                            {{ property?.uuid }}
                                        </p>
                                    </div>

                                    <div class="">
                                        <p class="font-[500] text-sm">Type</p>
                                        <p class="text-lg capitalize">
                                            {{ property?.type }}
                                        </p>
                                    </div>

                                    <div class="">
                                        <p class="font-[500] text-sm">
                                            Category
                                        </p>
                                        <p class="text-lg capitalize">
                                            {{ property?.category }}
                                        </p>
                                    </div>
                                    <div class="">
                                        <p class="font-[500] text-sm">
                                            Market Status
                                        </p>
                                        <p class="text-lg capitalize">
                                            {{ property?.status }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <p class="font-bold text-xl">Features</p>
                                <div class="w-full flex flex-wrap gap-10 mt-2">
                                    <p
                                        class="capitalize"
                                        v-for="(r, n) in property.features"
                                        :key="n"
                                    >
                                        - {{ r?.name }}
                                    </p>
                                </div>
                            </div>
                            <div class="w-full mt-5">
                                <p class="">Details</p>
                                <div
                                    class=""
                                    v-html="property?.description"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <div class="w-[30%] md:w-full">
                        <div class="w-full bg-white rounded-none">
                            <div
                                class="w-full flex justify-between items-center px-[20px] py-[10px] border-b-2"
                            >
                                <p class="">Maybe Advert Here</p>
                            </div>
                            <div class="w-full h-[100px]"></div>
                        </div>

                        <div class="w-full bg-white rounded-none mt-5 mb-5">
                            <div
                                class="w-full flex justify-between items-center px-[20px] py-[10px] border-b-2"
                            >
                                <p class="">Similar Properties</p>
                            </div>
                        </div>

                        <div v-for="r in others" :key="r.uuid" class="w-full">
                            <SingleDisplay :property="r" :key="r.uuid" />
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
