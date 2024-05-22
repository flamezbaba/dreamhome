<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    page_title: String,
    keyword: String,
    type: String,
    category: String,
    types: Object | Array,
    categories: Object | Array,
    properties: Object | Array,
});

const modals = ref({ search: false });
const tabx = ref(props.categories[0]?.name);
const searchForm = useForm({
    search_property: true,
    type: props?.type,
    bedrooms: null,
    keyword: props?.keyword,
    category: props?.category,
    property_id: null,
    min_price: null,
    max_price: null,
});

onMounted(() => {
    // console.log("i need");
});

import Layout from "@/Layouts/Home.vue";
import PlainModal from "@/Components/Modals/Plain.vue";
import SingleDisplay from "@/Components/SingleDisplay.vue";
import {
    mdiFilterCog,
    mdiClose,
    mdiMagnify,
    mdiMapMarker,
    mdiToilet,
    mdiRestore,
    mdiBedOutline,
    mdiArrowLeftThin,
    mdiArrowRightThin,
    mdiBathtubOutline,
    mdiTuneVerticalVariant,
    mdiHeart,
} from "@mdi/js";
</script>

<template>
    <Layout :title="page_title">
        <template #page-modal>
            <PlainModal :show="modals.search">
                <template #modal-content>
                    <div class="w-[67%] md:w-[84%] bg-white rounded-md">
                        <div
                            class="w-full flex justify-between items-center px-[20px] py-[10px] border-b-2"
                        >
                            <p class="text-lg">Advance Search</p>
                            <svg-icon
                                @click="modals.search = false"
                                type="mdi"
                                :size="20"
                                :path="mdiClose"
                                class="cursor-pointer"
                            ></svg-icon>
                        </div>
                        <div
                            class="w-full px-[20px] pb-[20px] mt-[20px] md:mt-[5px]"
                        >
                            <div
                                class="w-full flex md:flex-wrap gap-5 md:gap-3"
                            >
                                <div class="w-1/12 md:w-full">
                                    <p class="text-sm">&nbsp;</p>
                                    <select class="capitalize">
                                        <option
                                            :value="r.name"
                                            v-for="r in categories"
                                        >
                                            {{ r.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="w-4/12 md:w-full">
                                    <p class="text-sm">Keyword</p>
                                    <input
                                        v-model="searchForm.keyword"
                                        type="text"
                                        class=""
                                        placeholder="Search"
                                    />
                                </div>

                                <div class="w-3/12 md:w-6/12">
                                    <p class="text-sm">Type</p>
                                    <select class="capitalize">
                                        <option
                                            :value="r.name"
                                            v-for="r in types"
                                        >
                                            {{ r.name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="w-1/12 md:w-5/12">
                                    <p class="text-sm">Bedrooms</p>
                                    <select class="">
                                        <option value="any">Any</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6+</option>
                                    </select>
                                </div>

                                <div class="w-2/12 md:w-full">
                                    <p class="text-sm">Property ID</p>
                                    <input type="text" class="" />
                                </div>
                            </div>
                            <div
                                class="w-full flex md:flex-wrap mt-5 gap-5 md:gap-3"
                            >
                                <div class="w-2/12 md:w-6/12">
                                    <p class="text-sm">Min Price</p>
                                    <select class="">
                                        <option value="">None</option>
                                        <option value="100000">
                                            ₦ 100,000
                                        </option>
                                        <option value="200000">
                                            ₦ 200,000
                                        </option>
                                        <option value="250000">
                                            ₦ 250,000
                                        </option>
                                        <option value="300000">
                                            ₦ 300,000
                                        </option>
                                        <option value="400000">
                                            ₦ 400,000
                                        </option>
                                        <option value="500000">
                                            ₦ 500,000
                                        </option>
                                        <option value="600000">
                                            ₦ 600,000
                                        </option>
                                        <option value="700000">
                                            ₦ 700,000
                                        </option>
                                        <option value="750000">
                                            ₦ 750,000
                                        </option>
                                        <option value="800000">
                                            ₦ 800,000
                                        </option>
                                        <option value="900000">
                                            ₦ 900,000
                                        </option>
                                        <option value="1000000">
                                            ₦ 1 Million
                                        </option>
                                        <option value="2000000">
                                            ₦ 2 Million
                                        </option>
                                        <option value="3000000">
                                            ₦ 3 Million
                                        </option>
                                        <option value="5000000">
                                            ₦ 5 Million
                                        </option>
                                        <option value="10000000">
                                            ₦ 10 Million
                                        </option>
                                        <option value="20000000">
                                            ₦ 20 Million
                                        </option>
                                        <option value="30000000">
                                            ₦ 30 Million
                                        </option>
                                        <option value="40000000">
                                            ₦ 40 Million
                                        </option>
                                        <option value="60000000">
                                            ₦ 60 Million
                                        </option>
                                        <option value="80000000">
                                            ₦ 80 Million
                                        </option>
                                        <option value="100000000">
                                            ₦ 100 Million
                                        </option>
                                        <option value="150000000">
                                            ₦ 150 Million
                                        </option>
                                        <option value="200000000">
                                            ₦ 200 Million
                                        </option>
                                        <option value="250000000">
                                            ₦ 250 Million
                                        </option>
                                        <option value="300000000">
                                            ₦ 300 Million
                                        </option>
                                        <option value="400000000">
                                            ₦ 400 Million
                                        </option>
                                        <option value="500000000">
                                            ₦ 500 Million
                                        </option>
                                        <option value="600000000">
                                            ₦ 600 Million
                                        </option>
                                        <option value="700000000">
                                            ₦ 700 Million
                                        </option>
                                        <option value="800000000">
                                            ₦ 800 Million
                                        </option>
                                        <option value="900000000">
                                            ₦ 900 Million
                                        </option>
                                        <option value="1000000000">
                                            ₦ 1 Billion
                                        </option>
                                        <option value="2000000000">
                                            ₦ 2 Billion
                                        </option>
                                        <option value="5000000000">
                                            ₦ 5 Billion
                                        </option>
                                        <option value="10000000000">
                                            ₦ 10 Billion
                                        </option>
                                        <option value="20000000000">
                                            ₦ 20 Billion
                                        </option>
                                        <option value="30000000000">
                                            ₦ 30 Billion
                                        </option>
                                        <option value="40000000000">
                                            ₦ 40 Billion
                                        </option>
                                        <option value="50000000000">
                                            ₦ 50 Billion
                                        </option>
                                    </select>
                                </div>

                                <div class="w-2/12 md:w-5/12">
                                    <p class="text-sm">Max Price</p>
                                    <select class="">
                                        <option value="">None</option>
                                        <option value="100000">
                                            ₦ 100,000
                                        </option>
                                        <option value="200000">
                                            ₦ 200,000
                                        </option>
                                        <option value="250000">
                                            ₦ 250,000
                                        </option>
                                        <option value="300000">
                                            ₦ 300,000
                                        </option>
                                        <option value="400000">
                                            ₦ 400,000
                                        </option>
                                        <option value="500000">
                                            ₦ 500,000
                                        </option>
                                        <option value="600000">
                                            ₦ 600,000
                                        </option>
                                        <option value="700000">
                                            ₦ 700,000
                                        </option>
                                        <option value="750000">
                                            ₦ 750,000
                                        </option>
                                        <option value="800000">
                                            ₦ 800,000
                                        </option>
                                        <option value="900000">
                                            ₦ 900,000
                                        </option>
                                        <option value="1000000">
                                            ₦ 1 Million
                                        </option>
                                        <option value="2000000">
                                            ₦ 2 Million
                                        </option>
                                        <option value="3000000">
                                            ₦ 3 Million
                                        </option>
                                        <option value="5000000">
                                            ₦ 5 Million
                                        </option>
                                        <option value="10000000">
                                            ₦ 10 Million
                                        </option>
                                        <option value="20000000">
                                            ₦ 20 Million
                                        </option>
                                        <option value="30000000">
                                            ₦ 30 Million
                                        </option>
                                        <option value="40000000">
                                            ₦ 40 Million
                                        </option>
                                        <option value="60000000">
                                            ₦ 60 Million
                                        </option>
                                        <option value="80000000">
                                            ₦ 80 Million
                                        </option>
                                        <option value="100000000">
                                            ₦ 100 Million
                                        </option>
                                        <option value="150000000">
                                            ₦ 150 Million
                                        </option>
                                        <option value="200000000">
                                            ₦ 200 Million
                                        </option>
                                        <option value="250000000">
                                            ₦ 250 Million
                                        </option>
                                        <option value="300000000">
                                            ₦ 300 Million
                                        </option>
                                        <option value="400000000">
                                            ₦ 400 Million
                                        </option>
                                        <option value="500000000">
                                            ₦ 500 Million
                                        </option>
                                        <option value="600000000">
                                            ₦ 600 Million
                                        </option>
                                        <option value="700000000">
                                            ₦ 700 Million
                                        </option>
                                        <option value="800000000">
                                            ₦ 800 Million
                                        </option>
                                        <option value="900000000">
                                            ₦ 900 Million
                                        </option>
                                        <option value="1000000000">
                                            ₦ 1 Billion
                                        </option>
                                        <option value="2000000000">
                                            ₦ 2 Billion
                                        </option>
                                        <option value="5000000000">
                                            ₦ 5 Billion
                                        </option>
                                        <option value="10000000000">
                                            ₦ 10 Billion
                                        </option>
                                        <option value="20000000000">
                                            ₦ 20 Billion
                                        </option>
                                        <option value="30000000000">
                                            ₦ 30 Billion
                                        </option>
                                        <option value="40000000000">
                                            ₦ 40 Billion
                                        </option>
                                        <option value="50000000000">
                                            ₦ 50 Billion
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="mt-[20px] w-full">
                                <p class="font-semibold text-lg">Amenities</p>
                                <div class="w-full flex flex-wrap gap-5">
                                    <div
                                        class="inline-flex items-center w-auto"
                                        v-for="r in 12"
                                        :key="r"
                                    >
                                        <input
                                            class=""
                                            type="checkbox"
                                            :id="r"
                                        />
                                        <label :for="r">Air Condition</label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="mt-[20px] w-full flex justify-between">
                                <button
                                    class="bgx-blue rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                                >
                                    <p class="md:hidden lg:visible">Search</p>
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiMagnify"
                                        ></svg-icon>
                                    </span>
                                </button>

                                <button
                                    class="bg-red-500 rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                                >
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiRestore"
                                        ></svg-icon>
                                    </span>
                                    <p class="md:hidden lg:visible">Reset</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </PlainModal>
        </template>
        <template #page-content>
            <div class="w-full">
                <div
                    class="home-card w-full p-[50px] md:p-[10px] flex flex-col items-center justify-center"
                >
                    <div class="mt-5 w-[60%] md:w-[98%]">
                        <div
                            class="w-full h-[60px] md:h-auto md:py-4 bg-white/90 rounded-xl flex md:flex-col items-center gap-4 md:gap-1 px-4"
                        >
                            <div
                                class="flex-1 flex md:flex-col md:w-full items-center gap-5 md:gap-2 justify-start"
                            >
                                <input
                                    type="text"
                                    class=""
                                    placeholder="Search"
                                    v-model="searchForm.keyword"
                                />

                                <select class="" v-model="searchForm.type">
                                    <option
                                        :value="r.name"
                                        v-for="r in types"
                                        :key="r.id"
                                    >
                                        {{ r.name }}
                                    </option>
                                </select>
                            </div>

                            <div
                                class="flex md:justify-between md:w-full md:mt-3 gap-4 items-center"
                            >
                                <button
                                    @click="modals.search = true"
                                    class="bgx-blue rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                                >
                                    <svg-icon
                                        type="mdi"
                                        :size="16"
                                        :path="mdiTuneVerticalVariant"
                                    ></svg-icon>
                                </button>
                                <button
                                    @click="handleSearch"
                                    :class="{
                                        'opacity-25': searchForm.processing,
                                    }"
                                    :disabled="searchForm.processing"
                                    class="bgx-blue rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                                >
                                    <p class="md:hidden lg:visible">Search</p>
                                    <span class="mt-[2px]">
                                        <svg-icon
                                            type="mdi"
                                            :size="16"
                                            :path="mdiMagnify"
                                        ></svg-icon>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full flex justify-center md:flex-col px-[50px] pt-[20px] pb-[50px] md:px-[20px] bg-gray-500"
                >
                    <div class="w-[70%] md:w-full">
                        <div
                            class="w-full mb-5 bg-gray-100 py-3 px-5 flex items-center justify-between shadow-md rounded-md"
                        >
                            <p class="">
                                Result {{ properties.from }} -
                                {{ properties.to }} of {{ properties.total }}
                            </p>
                            <div class="">
                                <select class="">
                                    <option value="any">Sort By Default</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6+</option>
                                </select>
                            </div>
                        </div>

                        <div
                            v-for="r in properties.data"
                            :key="r.uuid"
                            class="w-full"
                        >
                            <SingleDisplay :property="r" :key="r.uuid" />
                        </div>

                        <div
                            class="w-full mb-5py-3 px-5 flex gap-5 items-center justify-center"
                        >
                            <a
                                :href="properties.prev_page_url"
                                :class="[
                                    properties.prev_page_url
                                        ? 'bgx-blue'
                                        : 'bg-blue-400',
                                ]"
                                class="cursor-pointer rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                            >
                                <span class="mt-[2px]">
                                    <svg-icon
                                        type="mdi"
                                        :size="16"
                                        :path="mdiArrowLeftThin"
                                    ></svg-icon>
                                </span>
                                <p class="md:hidden lg:visible">Prev</p>
                            </a>

                            <a
                                :href="properties.next_page_url"
                                :class="[
                                    properties.next_page_url
                                        ? 'bgx-blue'
                                        : 'bg-blue-400',
                                ]"
                                class="cursor-pointer rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                            >
                                <p class="md:hidden lg:visible">Next</p>
                                <span class="mt-[2px]">
                                    <svg-icon
                                        type="mdi"
                                        :size="16"
                                        :path="mdiArrowRightThin"
                                    ></svg-icon>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Layout>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";

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
        url("@/assets/img/home2.jpg");

    background-size: cover;
    background-position: center;
}
</style>
