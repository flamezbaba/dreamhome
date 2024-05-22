<script setup>
import { onMounted, ref } from "vue";
// import ClickOutside from "vue-click-outside";

const props = defineProps({
    options: {
        type: Object,
        required: true,
    },
    tabindex: {
        type: Number,
        required: false,
        default: 0,
    },
    modelValue: String | Number
});

const emit = defineEmits(["update:modelValue"]);

const searchResult = ref(props.options);
const searchText = ref(null);
const defaultText = ref(null);
const isOpen = ref(false);

const searchRecords = () => {
    searchResult.value = props.options.filter((item) => {
        return item.text.toString().toLowerCase().includes(searchText.value);
    });
};

const clickSelect = (r) => {
    defaultText.value = r.text;
    emit('update:modelValue', r.value);
    closeDropDown();
}

const getTextFromValue = (value) => {
    const rr = props.options.filter((item) => {
        return item.value == value;
    });

    if(rr.length  > 0){
        return rr[0].text;
    }
    else{
        return null;
    }
}
const closeDropDown = () => {
   isOpen.value = false;
   searchText.value = null;
   searchResult.value = props.options;
}

onMounted(() => {

    if(props.modelValue){
        defaultText.value = getTextFromValue(props.modelValue);
    }
    else{
        if (props.options.length > 0){
            defaultText.value = props.options[0].text;
        }
        else{
            defaultText.value = null;
        }
    }
});
</script>

<template>
    <div class="wrapper w-full" :tabindex="tabindex">
        <div class="select" :value="modelValue" @click="isOpen = !isOpen">
            {{ defaultText }}
        </div>
        <div class="select-dropdown" v-if="isOpen" v-click-outside="closeDropDown">
            <div class="search">
                <input
                    type="text"
                    placeholder="search"
                    class="form-control"
                    v-model="searchText" @input="searchRecords"
                />
            </div>
            <div class="search-result">
                <div
                    class="item" :class="option.value == modelValue ? 'active' : ''"
                    v-for="(option, index) in searchResult"
                    :key="index" v-if="searchResult.length > 0" @click="clickSelect(option)"
                >
                    {{ option.text }}
                </div>
                <div class="no-result" v-else>
                    No Results found
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.wrapper {
    position: relative;
}
.select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    width: 100%;
    height: 37px;
    border: 1px solid #6b7280;
    outline: none;
    border-radius: 0px;
    font-size: 1rem;
    padding-left: 10px;
    padding-top: 5px;
    overflow: hidden;
}

.select-dropdown {
    position: absolute;
    width: 100%;
    height: auto;
    background-color: #fbfbfb;
    border: 1px solid #6b7280;
    box-shadow: 1px 1px 2px rgba(0,0,0,.3);
    border-top: none;
    z-index: 600;

    .search {
        width: 100%;
        padding: 5px 5px;

        input {
            width: 100%;
        }
    }

    .search-result {
        text-transform: uppercase;

        .no-result {
            padding: 7px 5px;
        }

        .item {
            padding: 7px 5px;
            cursor: pointer;

            &.active {
                background-color: #328aee;
                color: #fff;
            }

            &:hover {
                background-color: #328aee;
                color: #fff;
            }
        }
    }
}
</style>
