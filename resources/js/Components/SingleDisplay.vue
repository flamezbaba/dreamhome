<script setup>
import { onMounted, ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useBasicStore } from "@/stores/basic";

import basicUtils from "@/Utils/basic.js";

const props = defineProps({ property: Array | Object });

const basicStore = useBasicStore();

defineEmits(["onpick"]);

onMounted(() => {});

import {
    mdiMapMarker,
    mdiToilet,
    mdiBedOutline,
    mdiBathtubOutline,
    mdiHeart,
} from "@mdi/js";
</script>

<template>
    <a
        :href="route('property.view', property.uuid)"
        class="w-full h-auto mb-10 flex md:flex-col rounded-2xl shadow-lg overflow-hidden relative"
    >
        <div
            class="w-[40%] md:w-full h-[calc(100%)]rounded-none overflow-hidden relative bg-gray-100"
        >
            <img
                :src="property.images[0]"
                alt=""
                class="aspect-[320/160] object-cover w-full h-full duration-500 hover:scale-150"
            />
            <div
                @click="basicStore.toggleFav(property.uuid)"
                :class="[
                    basicStore.isFav(property.uuid)
                        ? 'text-red-500 hover:text-gray-100'
                        : 'text-gray-100 hover:text-red-500',
                ]"
                class="absolute duration-500 top-3 right-3"
            >
                <svg-icon
                    type="mdi"
                    :size="30"
                    :path="mdiHeart"
                    class="cursor-pointer"
                ></svg-icon>
            </div>

            <div
                class="w-full absolute bottom-0 left-0 bg-gradient-to-b from-transparent to-black/80"
            >
                <div class="w-full h-full p-3 pb-5 text-white">
                    <p
                        class="capitalize break-words font-bold text-xl leading-none"
                    >
                    {{ property?.currency?.symbol }}
                        {{ Number(property.price).toLocaleString() }}
                    </p>
                    <p class="text-lg leading-none lowercase">
                        {{ property.price_suffix }}
                    </p>
                </div>
            </div>
        </div>
        <div
            class="w-[60%] md:w-full flex flex-col justify-between p-5 bg-gray-100"
        >
            <div class="w-full">
                <p class="capitalize break-words font-semibold text-xl">
                    {{ property.title }}
                </p>

                <div
                    v-if="property.state"
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
                        {{ property.city }} {{ property.state }}
                    </p>
                </div>

                <div class="mt-5">
                    <div
                        class="w-full block max-h-[112px] overflow-hidden break-words"
                        v-html="property.description"
                    ></div>
                    <div class="mt-4">
                        <a class="text-sm">...Read More</a>
                    </div>
                </div>
            </div>
            <div
                class=""
                v-if="
                    property.bedrooms || property.bathrooms || property.toilets
                "
            >
                <div class="h-[1px] w-full bg-[#eee] mt-5"></div>
                <div class="bt2 flex justify-between items-start mt-2">
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
                        <p class="">{{ property.bathrooms }} Baths</p>
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
                        <p class="">{{ property.toilets }} Toilets</p>
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
</style>
