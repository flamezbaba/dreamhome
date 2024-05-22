<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, computed } from "vue";
import h1 from "@/assets/img/home2.jpg";
import h2 from "@/assets/img/casa1.jpg";
import h3 from "@/assets/img/casa2.jpg";

const props = defineProps({
    page_title: String,
    types: Object | Array,
    categories: Object | Array,
    latest_properties: Object | Array,
});

const modals = ref({ search: false });
const tabx = ref(props.categories[0]?.name);
const searchForm = useForm({
    search_property: true,
    type: props.types[0]?.name,
    bedrooms: null,
    keyword: null,
    category: null,
    property_id: null,
    min_price: null,
    max_price: null,
});

const bottomSlides = ref([
    {
        image: "casa1.jpg",
    },
    {
        image: "casa2.jpg",
    },
    {
        image: "casa3.jpg",
    },
    {
        image: "casa4.jpg",
    },
]);
const heroSlider = ref([
    {
        image: h1,
    },
    {
        image: h2,
    },
    {
        image: h3,
    },
]);

const happy = ref([
    {
        name: "Aliko Dangote",
        location: "Lagos, Nigeria",
        story: "Working with dreamhome is like having a family member who can fix everything. They know what you need, exactly when you need it. Highly recommend and happy with thier company. ",
        avatar: "",
    },
    {
        name: "Sarah Kelvin",
        location: "Lagos, Nigeria",
        story: "Working with dreamhome is like having a family member who can fix everything. They know what you need, exactly when you need it. Highly recommend and happy with thier company. ",
        avatar: "",
    },
    {
        name: "Dantata Ibrahim",
        location: "Abuja, Nigeria",
        story: "Working with dreamhome is like having a family member who can fix everything. They know what you need, exactly when you need it. Highly recommend and happy with thier company. ",
        avatar: "",
    },
]);

const heroSliderInterval = ref(null);
const heroCounter = ref(0);

function runHeroSlider() {
    const min = 0;
    const max = 2;
    let type = "a";
    heroSliderInterval.value = setInterval(() => {
        if (heroCounter.value <= min) {
            type = "a";
        }

        if (heroCounter.value >= max) {
            type = "b";
        }

        if (type == "a") {
            heroCounter.value++;
        } else {
            heroCounter.value--;
        }
    }, 1500);
}

function handleSearch() {
    searchForm.transform((data) => ({
        ...data,
        category: tabx.value,
    }));

    searchForm.post(route("post.search"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // openModal.value.balance = false;
        },
    });
}

onMounted(() => {
    runHeroSlider();
});

onUnmounted(() => {
    clearInterval(heroSliderInterval.value);
});

import Layout from "@/Layouts/Home.vue";
import PlainModal from "@/Components/Modals/Plain.vue";
import {
    mdiFilterCog,
    mdiClose,
    mdiMagnify,
    mdiMapMarker,
    mdiToilet,
    mdiRestore,
    mdiBedOutline,
    mdiCommentQuote,
    mdiBathtubOutline,
    mdiTuneVerticalVariant,
} from "@mdi/js";

import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
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
                                    <select v-model="tabx" class="capitalize">
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
                                    <select
                                        v-model="searchForm.type"
                                        class="capitalize"
                                    >
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
                                    <select
                                        class=""
                                        v-model="searchForm.bedrooms"
                                    >
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
                                    <input
                                        type="text"
                                        class=""
                                        v-model="searchForm.property_id"
                                    />
                                </div>
                            </div>
                            <div
                                class="w-full flex md:flex-wrap mt-5 gap-5 md:gap-3"
                            >
                                <div class="w-2/12 md:w-6/12">
                                    <p class="text-sm">Min Price</p>
                                    <select
                                        class=""
                                        v-model="searchForm.min_price"
                                    >
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
                                    <select
                                        class=""
                                        v-model="searchForm.max_price"
                                    >
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

                                <button
                                    @click="searchForm.reset()"
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
                    :style="`background: linear-gradient(to bottom, rgba(28, 28, 30, 0.5), rgba(28, 28, 30, 0.9)) ,url(${heroSlider[heroCounter].image}); background-size: cover;`"
                    class="home-card w-full h-[600px] p-[50px] md:p-[10px] flex flex-col items-center justify-center"
                >
                    <p
                        class="text-white text-center font-bold text-5xl md:text-2xl uppercase"
                    >
                        We'll help you find a place you'll love
                    </p>
                    <p class="text-white text-center mt-2 text-lg">
                        Find a variety of properties that suit you very easily,
                        forget all difficulties in finding a residence for you
                    </p>
                    <div class="mt-5 w-[60%] md:w-[98%]">
                        <div class="flex">
                            <div
                                @click="tabx = r.name"
                                class="tabx capitalize"
                                :class="[tabx == r.name ? 'active' : '']"
                                v-for="r in categories"
                                :key="r.id"
                            >
                                {{ r.name }}
                            </div>
                        </div>
                        <div
                            class="w-full h-[60px] md:h-auto md:py-4 bg-white/90 rounded-bl-xl rounded-br-xl rounded-tr-xl flex md:flex-col items-center gap-4 md:gap-1 px-4"
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
                    class="w-full px-[50px] pt-[70px] pb-[50px] md:px-[20px] bg-gray-500"
                >
                    <div class="w-full">
                        <div class="text-center text-white">
                            <p class="text-5xl md:text-2xl font-bold">
                                Discover The Latest Properties
                            </p>
                            <p class="text-xl md:text-sm mt-3">
                                Find a property that's right for you.
                            </p>
                        </div>

                        <div
                            class="w-full h-[400px] flex flex-col flex-wrap justify-center items-center gap-10 md:gap-8 pb-5 scroll-smooth mt-10 overflow-scroll"
                        >
                            <a
                                :href="route('property.view', r.uuid)"
                                v-for="r in latest_properties"
                                :key="r.uuid"
                                class="w-[320px] h-[360px] md:w-[290px] rounded-2xl shadow-lg overflow-hidden"
                            >
                                <div
                                    class="w-full h-[200px] rounded-none overflow-hidden relative bg-gray-100"
                                >
                                    <img
                                        :src="r.images[0]"
                                        alt=""
                                        class="aspect-[320/160] object-cover w-full h-full duration-500 hover:scale-150"
                                    />
                                    <div
                                        class="w-full absolute bottom-0 left-0 bg-gradient-to-b from-transparent to-black/80"
                                    >
                                        <div
                                            class="w-full h-full p-3 text-white"
                                        >
                                            <p
                                                class="capitalize break-words font-bold text-xl leading-none"
                                            >
                                                {{ r?.currency?.symbol }}
                                                {{
                                                    Number(
                                                        r.price
                                                    ).toLocaleString()
                                                }}
                                            </p>
                                            <p
                                                class="text-lg leading-none lowercase"
                                            >
                                                {{ r.price_suffix }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-[20px] py-[15px] h-[calc(100%_-_200px)] flex flex-col justify-between bg-slate-200"
                                >
                                    <div class="">
                                        <p
                                            class="capitalize break-words font-semibold text-xl"
                                        >
                                            {{ r.title }}
                                        </p>
                                        <div
                                            v-if="r.state"
                                            class="flex gap-1 items-center text-[var(--bt-2)] mt-1"
                                        >
                                            <span class="mt-[2px]">
                                                <svg-icon
                                                    type="mdi"
                                                    :size="16"
                                                    :path="mdiMapMarker"
                                                ></svg-icon>
                                            </span>
                                            <p
                                                class="break-words bt2 capitalize"
                                            >
                                                {{ r.city }}, {{ r.state }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div
                                            v-if="
                                                r.bedrooms ||
                                                r.bathrooms ||
                                                r.toilets
                                            "
                                            class="h-[1px] w-full bg-[#eee] mt-5"
                                        ></div>
                                        <div
                                            class="bt2 flex justify-between items-start mt-2"
                                        >
                                            <div
                                                v-if="r.bedrooms"
                                                class="flex gap-1 items-center mt-1"
                                            >
                                                <span class="mt-[2px]">
                                                    <svg-icon
                                                        type="mdi"
                                                        :size="16"
                                                        :path="mdiBedOutline"
                                                    ></svg-icon>
                                                </span>
                                                <p class="">
                                                    {{ r.bedrooms }}
                                                </p>
                                            </div>

                                            <div
                                                v-if="r.bathrooms"
                                                class="flex gap-1 items-center mt-1"
                                            >
                                                <span class="mt-[2px]">
                                                    <svg-icon
                                                        type="mdi"
                                                        :size="16"
                                                        :path="
                                                            mdiBathtubOutline
                                                        "
                                                    ></svg-icon>
                                                </span>
                                                <p class="">
                                                    {{ r.bathrooms }}
                                                </p>
                                            </div>

                                            <div
                                                v-if="r.toilets"
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
                                                    {{ r.toilets }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full px-[50px] py-[70px] pb-[60px] md:px-[20px] bg-gray-500"
                >
                    <div class="w-full text-white">
                        <div class="text-center">
                            <p class="text-5xl md:text-2xl font-bold">
                                Explore The Neighborhoods
                            </p>
                            <p class="text-xl md:text-sm mt-3">
                                Find your dream apartment with our listing.
                            </p>
                        </div>
                    </div>

                    <div class="w-full px-[50px] md:px-[5px] py-[40px]">
                        <Carousel
                            :autoplay="1200"
                            :wrap-around="true"
                            :pause-autoplay-on-hover="true"
                        >
                            <!-- <Slide v-for="(r, n) in bottomSlides" :key="n"> -->
                            <Slide :key="11">
                                <div
                                    class="w-full h-[400px] md:w-full rounded-2xl shadow-lg overflow-hidden relative"
                                >
                                    <img
                                        src="@/assets/img/l1.jpg"
                                        alt=""
                                        class="aspect-[320/160] object-cover w-full h-full duration-500 hover:scale-150"
                                    />
                                    <div
                                        class="w-full absolute bottom-0 left-0 bg-gradient-to-b from-transparent pt-6 to-black/80"
                                    >
                                        <div
                                            class="w-full h-full p-3 text-white"
                                        >
                                            <p
                                                class="capitalize break-words font-bold text-xl"
                                            >
                                                Ikeja
                                            </p>
                                            <p class="text-lg">
                                                200 Properties
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </Slide>

                            <Slide :key="22">
                                <div
                                    class="w-full h-[400px] md:w-full rounded-2xl shadow-lg overflow-hidden relative"
                                >
                                    <img
                                        src="@/assets/img/l2.jpg"
                                        alt=""
                                        class="aspect-[320/160] object-cover w-full h-full duration-500 hover:scale-150"
                                    />
                                    <div
                                        class="w-full absolute bottom-0 left-0 bg-gradient-to-b from-transparent pt-6 to-black/80"
                                    >
                                        <div
                                            class="w-full h-full p-3 text-white"
                                        >
                                            <p
                                                class="capitalize break-words font-bold text-xl"
                                            >
                                                Ikeja
                                            </p>
                                            <p class="text-lg">
                                                200 Properties
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </Slide>

                            <Slide :key="33">
                                <div
                                    class="w-full h-[400px] md:w-full rounded-2xl shadow-lg overflow-hidden relative"
                                >
                                    <img
                                        src="@/assets/img/lekki.jpg"
                                        alt=""
                                        class="aspect-[320/160] object-cover w-full h-full duration-500 hover:scale-150"
                                    />
                                    <div
                                        class="w-full absolute bottom-0 left-0 bg-gradient-to-b from-transparent pt-6 to-black/80"
                                    >
                                        <div
                                            class="w-full h-full p-3 text-white"
                                        >
                                            <p
                                                class="capitalize break-words font-bold text-xl"
                                            >
                                                Ikeja
                                            </p>
                                            <p class="text-lg">
                                                200 Properties
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </Slide>

                            <Slide :key="44">
                                <div
                                    class="w-full h-[400px] md:w-full rounded-2xl shadow-lg overflow-hidden relative"
                                >
                                    <img
                                        src="@/assets/img/casa4.jpg"
                                        alt=""
                                        class="aspect-[320/160] object-cover w-full h-full duration-500 hover:scale-150"
                                    />
                                    <div
                                        class="w-full absolute bottom-0 left-0 bg-gradient-to-b from-transparent pt-6 to-black/80"
                                    >
                                        <div
                                            class="w-full h-full p-3 text-white"
                                        >
                                            <p
                                                class="capitalize break-words font-bold text-xl"
                                            >
                                                Ikeja
                                            </p>
                                            <p class="text-lg">
                                                200 Properties
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </Slide>

                            <template #addons>
                                <Navigation />
                                <Pagination />
                            </template>
                        </Carousel>
                    </div>
                </div>

                <div
                    class="w-full px-[250px] py-[40px] pb-[60px] md:px-[20px] bg-gray-500"
                >
                    <div class="w-full flex md:flex-col justify-between items-center">
                        <div
                            class="w-[400px] md:w-full mt-[70px] md:mt-[0px] text-white"
                        >
                            <div class="">
                                <p class="text-4xl font-bold">
                                    From our happy <br />customers
                                </p>
                                <p class="bt-2 mt-1 text-sm">
                                    Read some of our client testimonials about
                                    how and why they used Dream Home to buy and
                                    sell.
                                </p>
                            </div>
                            <Carousel
                                :autoplay="1200"
                                :wrap-around="true"
                                :pause-autoplay-on-hover="true"
                            >
                                <Slide v-for="(r, n) in happy" :key="n">
                                    <div class="mt-[40px]">
                                        <div class="text-blue-1">
                                            <svg-icon
                                                type="mdi"
                                                :size="36"
                                                :path="mdiCommentQuote"
                                            ></svg-icon>
                                        </div>
                                        <div class="mt-3">
                                            <p
                                                class="bt-2 text-2xl italic text-left"
                                            >
                                                {{ r.story }}
                                            </p>
                                        </div>
                                        <div
                                            class="w-full bg-blue-800 mt-3 h-[3px] discr relative"
                                        ></div>
                                        <div
                                            class="w-full flex mt-5 gap-3 items-center"
                                        >
                                            <img
                                                v-if="r.avatar"
                                                :src="r.avatar"
                                                class="rounded-full w-[50px] h-[50px] object-cover"
                                            />
                                            <div class="">
                                                <p class="font-semibold">
                                                    {{ r.name }}
                                                </p>
                                                <p class="">{{ r.location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </Slide>
                            </Carousel>
                        </div>
                        <div class="w-[calc(100%_-_400px)] md:w-full flex items-center justify-end md:justify-start md:mt-10">
                            <img
                                src="@/assets/img/group1.png"
                                alt=""
                                class="w-[70%] rounded-md"
                            />
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
    /* background: linear-gradient(
            to bottom,
            rgba(28, 28, 30, 0.5),
            rgba(28, 28, 30, 0.9)
        ),
        url("@/assets/img/home2.jpg"); */
    background-size: cover;
}
</style>
