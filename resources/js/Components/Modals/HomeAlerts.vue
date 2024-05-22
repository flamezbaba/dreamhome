<script setup>
import { computed, ref, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

const messages = ref([]);
const flash = computed(() => usePage().props.flash);

function remove(index) {
    messages.value.splice(index, 1);
}

function add(message) {
    messages.value.push(message);
}

watch(
    flash,
    () => {
        if (flash.value.homeerror) {
            const mm = add({
                type: "error",
                message: flash.value.homeerror.msg,
            });

            if (flash.value.homeerror.timer) {
                var tk = setTimeout(() => {
                    const index = messages.value.indexOf(mm);
                    remove(index);
                    clearTimeout(tk);
                }, 7500);
            }
        }

        if (flash.value.homesuccess) {
            const mm = add({
                type: "success",
                message: flash.value.homesuccess.msg,
            });

            if (flash.value.homesuccess.timer) {
                var tk = setTimeout(() => {
                    const index = messages.value.indexOf(mm);
                    remove(index);
                    clearTimeout(tk);
                }, 7500);
            }
        }
    },
    { deep: true }
);

onMounted(() => {
    if (flash.value.homeerror) {
        const mm = add({
            type: "error",
            message: flash.value.homeerror.msg,
        });

        if (flash.value.homeerror.timer) {
            var tk = setTimeout(() => {
                const index = messages.value.indexOf(mm);
                remove(index);
                clearTimeout(tk);
            }, 7500);
        }
    }

    if (flash.value.homesuccess) {
        const mm = add({
            type: "success",
            message: flash.value.homesuccess.msg,
        });

        if (flash.value.homesuccess.timer) {
            var tk = setTimeout(() => {
                const index = messages.value.indexOf(mm);
                remove(index);
                clearTimeout(tk);
            }, 7500);
        }
    }
});

import { mdiClose, mdiCancel, mdiCheck } from "@mdi/js";
</script>

<template>
    <div class="fixed z-50 md:px-[20px] left-[40%] space-y-5">
        <TransitionGroup name="list">
            <div
                v-for="(m, n) in messages"
                :key="n"
                :class="[
                    m.type == 'success' ? 'from-green-600 to-green-500' : '',
                    m.type == 'error' ? 'from-red-600 to-red-500' : '',
                ]"
                class="z-50 min-w-[400px] h-[40px] bg-gradient-to-r rounded-full flex items-center justify-between px-3"
            >
                <div class="text-white flex items-center gap-3">
                    <svg-icon
                        v-if="m.type == 'success'"
                        type="mdi"
                        :size="20"
                        :path="mdiCheck"
                        class="cursor-pointer text-white"
                    ></svg-icon>
                    <svg-icon
                        v-if="m.type == 'error'"
                        type="mdi"
                        :size="20"
                        :path="mdiCancel"
                        class="cursor-pointer text-white"
                    ></svg-icon>
                    <p class="text-lg">{{ m.message }}</p>
                </div>

                <svg-icon
                    @click="remove(n)"
                    type="mdi"
                    :size="20"
                    :path="mdiClose"
                    class="cursor-pointer text-white"
                ></svg-icon>
            </div>
        </TransitionGroup>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";

.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}
</style>
