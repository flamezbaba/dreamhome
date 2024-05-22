<script setup>
import { ref } from "vue";
import { mdiClose, mdiMagnify } from "@mdi/js";

defineProps({
    modelValue: String,
});

defineEmits(["update:modelValue", "onCancelSearch", "onRunSearch"]);

const input = ref(null);
</script>

<template>
    <div class="relative">
        <div
            @click="$emit('onCancelSearch')"
            v-if="modelValue"
            class="absolute inset-y-0 left-0 flex items-center pl-3 text-black cursor-pointer"
        >
            <svg-icon type="mdi" size="18" :path="mdiClose"></svg-icon>
        </div>
        <input
            type="text"
            ref="input"
            id="table-search-users"
            class="block p-2 pl-10 pr-10 text-base font-bold text-gray-900 border border-gray-300 rounded-sm w-80 bg-gray-100 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Search"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <div
            @click="$emit('onRunSearch')"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-black cursor-pointer"
        >
            <svg-icon type="mdi" size="18" :path="mdiMagnify"></svg-icon>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>
