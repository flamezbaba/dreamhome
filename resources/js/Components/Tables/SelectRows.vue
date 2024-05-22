<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: String | Number,
    totalRecords: String | Number,
});

const emit = defineEmits(["update:modelValue", "onSelect"]);

const showList = computed(() => {
    const perPage = 20;
    const totalRecords = props.totalRecords;
    const returnArr = [perPage];

    let newOne = perPage;
    let checker = 0;
    let count = 3;
    do {
        newOne = perPage * count;
        checker = checker + newOne;
        count = count * 2;
        returnArr.push(newOne);
    } while (checker < totalRecords);

    return returnArr;
});

const action = (e) => {
    emit("update:modelValue", e);
    emit("onSelect");
};
</script>

<template>
    <div class="">
        <label
            >Show
            <select
                :value="modelValue"
                @change="action($event.target.value)"
                class="ring-1 ring-gray-300 py-[2px] ml-[5px] mr-[5px] border-0"
            >
                <option :value="r" v-for="(r, key) in showList">
                    {{ r }}
                </option>
            </select>
            records</label
        >
    </div>
</template>

<style lang="scss" scoped></style>
