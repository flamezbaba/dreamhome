<script setup>
import { computed, ref, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

import { mdiClose } from "@mdi/js";

const show = ref(false);
const message = ref("");
const messageType = ref("message");
const messageTitle = ref("");
const messageClass = ref("message");
const flash = computed(() => usePage().props.flash);

onMounted(() => {
    if (flash.value.poperror) {
        doErr();
    }

    if (flash.value.popsuccess) {
        doSuc();
    }

    if (flash.value.popmessage) {
        doMsg();
    }
});

const doErr = () => {
    messageType.value = "error";
    messageClass.value = "error";
    message.value = flash.value.poperror;
    messageTitle.value = "Error";
    setTimeout(() => {
        show.value = true;
    }, 200);
};

const doSuc = () => {
    messageType.value = "success";
    messageClass.value = "success";
    message.value = null;
    messageTitle.value = flash.value.popsuccess;
    setTimeout(() => {
        show.value = true;
    }, 200);
};

const doMsg = () => {
    messageType.value = "message";
    message.value = null;
    messageTitle.value = flash.value.popmessage;
    setTimeout(() => {
        show.value = true;
    }, 200);
};

watch(
    flash,
    () => {
        show.value = false;
        if (flash.value.poperror) {
            doErr();
        }

        if (flash.value.popsuccess) {
            doSuc();
        }

        if (flash.value.popmessage) {
            doMsg();
        }
    },
    { deep: true }
);
</script>

<template>
    <div class="fixed right-[20px] top-[20px] z-[900] w-[400px] md:w-[80%]">
        <Transition name="slide-fade">
            <div class="p-wrapper" v-if="show" :class="messageClass">
                <div class="flex flex-col gap-[1px]">
                    <div class="flex justify-between">
                        <div
                            class="text-white font-bold text-lg"
                            v-html="messageTitle"
                        ></div>
                        <div
                            @click="show = false"
                            class="bg-[rgba(255,255,255,.3)] p-[3px] text-white rounded-md cursor-pointer"
                        >
                            <svg-icon type="mdi" :path="mdiClose"></svg-icon>
                        </div>
                    </div>
                    <div class="text-white text-lg" v-html="message"></div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";

.p-wrapper {
    padding: 20px;
    background: linear-gradient(110deg, #3e3ed7, #4949e7);
    border-radius: 5px;
    margin-bottom: 5px;

    &.error {
        background: linear-gradient(110deg, #cb2027, #cb2027);
    }

    &.success {
        background: linear-gradient(80deg, #009966, #33cc99);
    }
}

.slide-fade-enter-active {
    transition: all 0.2s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from {
    transform: translateX(200px);
    opacity: 0;
}

.slide-fade-leave-to {
    transform: translateY(-200px);
    opacity: 0;
}
</style>
