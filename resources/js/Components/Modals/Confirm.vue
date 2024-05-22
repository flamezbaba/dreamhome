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
    modalData: {
        type: Object,
        default: {
            heading: "Are You Sure ?",
            modalWord: "this action cannot be undone",
            buttonTwoText: "Yes",
            buttonOneText: "Cancel",
            actionTwo: "",
        },
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

watch(
    showComputed,
    () => {
        if(showComputed.value){
            basicUtils.disableScroll();
        }
        else{
            basicUtils.enableScroll();
        }
    },
);

onMounted(() => {
   
});
</script>

<template>
        <div class="modal-body" v-show="show">
            <transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <div
                    class="confirm-modal md:w-[85%] w-[400px] flex flex-col items-star"
                >
                    <div class="icon">
                        <svg-icon
                            type="mdi"
                            size="48"
                            :path="mdiCloseCircleOutline"
                        ></svg-icon>
                    </div>
                    <div class="alert-text">
                        <div class="heading">{{ modalData.heading ?? "" }}</div>
                        <div class="">
                            {{ modalData.modalWord ?? "" }}
                        </div>
                    </div>
                    <div class="action-buttons flex gap-5">
                        <button
                            class="inline-flex bg-gray-500 text-white font-bold px-[20px] py-[10px] rounded-md"
                            @click="closeModal"
                        >
                            {{ modalData.buttonOneText ?? "Cancel" }}
                        </button>

                        <button
                            class="inline-flex bg-red-500 hover:bg-red-600 text-white font-bold px-[20px] py-[10px] rounded-md"
                            @click="runActionTwo"
                        >
                            {{ modalData.buttonTwoText ?? "" }}
                        </button>
                    </div>
                </div>
            </transition>
        </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";

.modal-body {
    position: fixed;
    background-color: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 600;
    overflow: hidden;

    .confirm-modal {
        min-height: 100px;
        padding: 20px;
        box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.2);
        border-radius: 7px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;

        .icon {
            color: rgb(211, 80, 80);
        }

        .alert-text {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;

            .heading {
                font-weight: bold;
                margin-bottom: 10px;
            }
        }

        .action-buttons {
            button {
                transition: all 0.3s;
            }
        }
    }
}
</style>
