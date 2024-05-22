<script setup>
import { onMounted, ref, computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { mdiCloseCircleOutline } from "@mdi/js";

import basicUtils from "@/Utils/basic.js";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["modalClose", "modalActionTwo"]);

const closeModal = () => {
    emit("modalClose");
};

const runActionTwo = () => {
    emit("modalActionTwo", props.modalData.actionTwo);
};

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
    <div class="modal-wrapper" v-if="show">
        <div class="modal-body">
            <div
                class="modal-content md:w-[85%] h-auto w-[600px] flex flex-col items-start"
            >
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
    z-index: 800;
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
            box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            overflow: visible;
        }
    }
}
</style>
