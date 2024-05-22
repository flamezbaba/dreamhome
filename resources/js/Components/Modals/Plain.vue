<script setup>
import { onMounted, ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

import basicUtils from "@/Utils/basic.js";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});
const showComputed = computed(() => props.show);

watch(showComputed, () => {
    if (showComputed.value) {
        basicUtils.disableScroll();
    } else {
        basicUtils.enableScroll();
    }
});

onMounted(() => {});
</script>

<template>
    <div class="modal-wrapper z-40" v-if="show">
        <div class="modal-body">
            <div class="modal-content h-auto w-full">
                <slot name="modal-content"></slot>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";

.modal-wrapper {
    position: fixed;
    background-color: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    overflow: scroll;

    .modal-body {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        padding-top: 80px;
        padding-bottom: 80px;

        .modal-content {
            min-height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: visible;
        }
    }
}
</style>
