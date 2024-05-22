<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

import { mdiMenuDown } from "@mdi/js";

const props = defineProps({
    actions: {
        type: Object,
        default: [],
    },
});

const emit = defineEmits(["actionClicked"]);

const dropDownOpen = ref(false);
const closeDropDown = () => {
    dropDownOpen.value = false;
}
</script>

<template>
    <div class="relative">
        <div
            v-if="actions.length > 0"
            @click="dropDownOpen = !dropDownOpen"
            
            class="inline-flex cursor-pointer items-center text-white py-[7px] px-[20px] bg-slate-600 rounded-md"
        >
            <span class="text-[12px] font-bold">Actions</span
            ><svg-icon type="mdi" size="20" :path="mdiMenuDown"></svg-icon>
        </div>
        <div class="" v-else>-</div>
        <div
            v-if="dropDownOpen"
            @mouseleave="dropDownOpen = false"
            v-click-outside="closeDropDown"
            class="action-dropdown absolute top-[calc(100%)] left-0 bg-white w-[160px] py-[10px] z-[500] list-none rounded-[5px]"
        >
            <li
                class="hover:bg-gray-200 cursor-pointer px-[10px] py-[5px]"
                v-for="(action, aindex) in actions"
                :key="aindex"
            >
                <Link
                    :href="action.link"
                    v-if="action.type == 'link'"
                    class="w-full flex"
                    >{{ action.title }}</Link
                >
                <div
                    class=""
                    @click="emit('actionClicked', action.link)"
                    v-else
                >
                    {{ action.title }}
                </div>
            </li>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.action-dropdown {
    box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.4);
}
</style>
