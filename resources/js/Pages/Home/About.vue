<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, computed } from "vue";
import h1 from "@/assets/img/home2.jpg";
import h2 from "@/assets/img/casa1.jpg";
import h3 from "@/assets/img/casa2.jpg";

const props = defineProps({
    page_title: String,
});

onMounted(() => {});

onUnmounted(() => {});

import Layout from "@/Layouts/Home.vue";
import PlainModal from "@/Components/Modals/Plain.vue";
import { mdiPhone, mdiEmailFast, mdiMapMarker } from "@mdi/js";
</script>

<template>
    <Layout :title="page_title">
        <template #page-modal> </template>
        <template #page-content>
            <div class="w-full">
                <!-- <div
                    class="home-card w-full p-[50px] md:p-[10px] flex flex-col items-center justify-center"
                >
                   
                </div> -->

                <div
                    class="w-full flex md:flex-col px-[150px] pt-[120px] pb-[50px] md:px-[20px] bg-gray-500"
                >
                    <div class="text-white w-1/2 md:w-full">
                        <p class="text-5xl font-bold ">
                            We provide the most suitable and quality real
                            estate.
                        </p>
                        <div class="mt-20 space-y-6">
                            <div class="flex gap-3 items-center">
                                <svg-icon
                                    type="mdi"
                                    :size="36"
                                    :path="mdiPhone"
                                ></svg-icon>
                                <span class="text-2xl">+2349165892223</span>
                            </div>
                            <div class="flex gap-3 items-center">
                                <svg-icon
                                    type="mdi"
                                    :size="36"
                                    :path="mdiMapMarker"
                                ></svg-icon>
                                <span class="text-2xl">Lekki, Lagos Nigeria</span>
                            </div>
                            <div class="flex gap-3 items-center">
                                <svg-icon
                                    type="mdi"
                                    :size="36"
                                    :path="mdiEmailFast"
                                ></svg-icon>
                                <span class="text-2xl">info@dreamcardhomes.com</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 md:w-full">
                        <img src="@/assets/img/a1.png" alt="" class="w-[300px]">
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
