<script setup>
import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

const show = ref(true);
const flash = computed(() => usePage().props.flash);

watch(
    flash,
    () => {
        show.value = true;
    },
    { deep: true }
);
</script>

<template>
    <div>
        <div
            v-if="$page.props.flash.message && show"
            class="flex items-center justify-between w-full mb-8 bg-blue-500 rounded"
        >
            <div class="flex items-center">
                <svg
                    class="flex-shrink-0 ml-4 mr-2 w-4 h-4 fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
                </svg>

                <div class="py-4 text-white text-sm font-medium">
                    {{ $page.props.flash.message }}
                </div>
            </div>
            <button type="button" class="group mr-2 p-2" @click="show = false">
                <svg
                    class="block w-2 h-2 fill-green-800 group-hover:fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    width="235.908"
                    height="235.908"
                    viewBox="278.046 126.846 235.908 235.908"
                >
                    <path
                        d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"
                    />
                </svg>
            </button>
        </div>

        <div
            v-if="$page.props.flash.success && show"
            class="flex items-center justify-between w-full mb-8 bg-green-500 rounded"
        >
            <div class="flex items-center">
                <svg
                    class="flex-shrink-0 ml-4 mr-2 w-4 h-4 fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                    <polygon points="0 11 2 9 7 14 18 3 20 5 7 18" />
                </svg>
                <div class="py-4 text-white text-sm font-medium">
                    {{ $page.props.flash.success }}
                </div>
            </div>
            <button type="button" class="group mr-2 p-2" @click="show = false">
                <svg
                    class="block w-2 h-2 fill-green-800 group-hover:fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    width="235.908"
                    height="235.908"
                    viewBox="278.046 126.846 235.908 235.908"
                >
                    <path
                        d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"
                    />
                </svg>
            </button>
        </div>

        <div
            v-if="$page.props.flash.error && show"
            class="flex items-center justify-between mb-8 w-full bg-red-500 rounded"
        >
            <div class="flex items-center">
                <svg
                    class="flex-shrink-0 ml-4 mr-2 w-4 h-4 fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                    <path
                        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"
                    />
                </svg>
                <div class="py-4 text-white text-sm font-medium">
                    {{ $page.props.flash.error }}
                </div>
            </div>
            <button type="button" class="group mr-2 p-2" @click="show = false">
                <svg
                    class="block w-2 h-2 fill-red-800 group-hover:fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    width="235.908"
                    height="235.908"
                    viewBox="278.046 126.846 235.908 235.908"
                >
                    <path
                        d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"
                    />
                </svg>
            </button>
        </div>

        <div
            v-if="Object.keys($page.props.errors).length > 0 && show"
            class="flex items-center justify-between mb-8 w-full bg-red-500 rounded"
        >
            <div class="flex items-center">
                <svg
                    class="flex-shrink-0 ml-4 mr-2 w-4 h-4 fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                    <path
                        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z"
                    />
                </svg>

                <div class="py-4 text-white text-sm font-medium">
                    <p v-for="(r, index) in $page.props.errors" :key="index">
                        {{ r }}
                    </p>
                </div>
            </div>
            <button type="button" class="group mr-2 p-2" @click="show = false">
                <svg
                    class="block w-2 h-2 fill-red-800 group-hover:fill-white"
                    xmlns="http://www.w3.org/2000/svg"
                    width="235.908"
                    height="235.908"
                    viewBox="278.046 126.846 235.908 235.908"
                >
                    <path
                        d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>
